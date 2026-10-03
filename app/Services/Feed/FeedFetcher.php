<?php

namespace App\Services\Feed;

use App\Models\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FeedFetcher
{
    private int $timeout = 30;
    private int $maxItems = 50;

        public function fetch(Source $source): array
    {
        if (! $source->feed_url) {
            Log::warning("Source [{$source->slug}] has no feed URL.");
            return [];
        }

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'User-Agent'     => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                    'Accept'          => 'application/rss+xml, application/xml, text/xml, */*',
                    'Accept-Language' => 'en,ar,fr,it,es',
                ])
                ->get($source->feed_url);

            if (! $response->successful()) {
                Log::error("Failed to fetch feed [{$source->slug}]: HTTP {$response->status()}");
                return [];
            }

            $items = $source->feed_type === 'youtube'
                ? $this->parseYoutube($response->body(), $source)
                : $this->parse($response->body(), $source);

            Log::info("Fetched {$source->slug}: " . count($items) . " items.");

            return $items;

        } catch (\Exception $e) {
            Log::error("Exception fetching [{$source->slug}]: " . $e->getMessage());
            return [];
        }
    }

        private function parseYoutube(string $xml, Source $source): array
    {
        $items = [];

        try {
            $feed = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOERROR);
            if ($feed === false) return [];

            $atom    = $feed->children('http://www.w3.org/2005/Atom');
            $entries = $feed->children('http://www.w3.org/2005/Atom')->entry ?? $feed->entry ?? [];

            foreach ($entries as $entry) {
                $media     = $entry->children('http://search.yahoo.com/mrss/');
                $videoId   = (string) ($entry->children('http://www.youtube.com/xml/schemas/2015')->videoId ?? '');
                $title     = (string) ($entry->title ?? '');
                $link      = (string) ($entry->link['href'] ?? '');
                $published = (string) ($entry->published ?? '');
                $thumbnail = (string) ($media->group->thumbnail['url'] ?? '');
                $desc      = (string) ($media->group->description ?? '');
                $channelName = (string) ($entry->author->name ?? $source->name);

                if (! $title || ! $link) continue;

                try {
                    $publishedAt = \Carbon\Carbon::parse($published)->toDateTimeString();
                } catch (\Exception $e) {
                    $publishedAt = now()->toDateTimeString();
                }

                $items[] = [
                    'source_id'      => $source->id,
                    'external_id'    => $videoId ?: mb_substr($link, 0, 255),
                    'url'            => $link,
                    'title'          => mb_substr($title, 0, 255),
                    'original_title' => mb_substr($title, 0, 255),
                    'description'    => mb_substr($desc, 0, 1000) ?: null,
                    'author'         => mb_substr($channelName, 0, 255),
                    'image_url'      => $thumbnail ?: null,
                    'language'       => $source->language,
                    'country_code'   => $source->country_code,
                    'published_at'   => $publishedAt,
                    'status'         => 'raw',
                    'metadata'       => json_encode([
                        'type'         => 'youtube',
                        'video_id'     => $videoId,
                        'channel_name' => $channelName,
                    ]),
                ];
            }

        } catch (\Exception $e) {
            Log::error("YouTube parse error [{$source->slug}]: " . $e->getMessage());
        }

        return $items;
    }
    private function parse(string $xml, Source $source): array
    {
        $items = [];

        try {
            $feed = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOERROR);

            if ($feed === false) {
                Log::error("Failed to parse XML for source [{$source->slug}]");
                return [];
            }

            $feedItems = $this->extractItems($feed);

            foreach (array_slice($feedItems, 0, $this->maxItems) as $item) {
                $parsed = $this->parseItem($item, $source);
                if ($parsed) {
                    $items[] = $parsed;
                }
            }

        } catch (\Exception $e) {
            Log::error("Parse error [{$source->slug}]: " . $e->getMessage());
        }

        return $items;
    }

    private function extractItems(\SimpleXMLElement $feed): array
    {
        // RSS 2.0
        if (isset($feed->channel->item)) {
            return iterator_to_array($feed->channel->item, false);
        }

        // RSS 1.0 / RDF
        $namespaces = $feed->getNamespaces(true);
        if (isset($namespaces['rdf']) || $feed->getName() === 'RDF') {
            return iterator_to_array($feed->item, false);
        }

        // Atom
        $atom = $feed->children('http://www.w3.org/2005/Atom');
        if (isset($atom->entry)) {
            return iterator_to_array($atom->entry, false);
        }

        return [];
    }

    private function parseItem(\SimpleXMLElement $item, Source $source): ?array
    {
        // ─── Title ────────────────────────────────────────────────
        $title = $this->extractText($item, ['title']);
        if (! $title) {
            return null;
        }

        // ─── URL ──────────────────────────────────────────────────
        $url = $this->extractUrl($item);
        if (! $url || ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        // ─── Description ──────────────────────────────────────────
        $description = $this->extractText($item, ['description', 'summary', 'content']);
        $description = $description ? strip_tags($description) : null;
        $description = $description ? mb_substr($description, 0, 1000) : null;

        // ─── Published At ─────────────────────────────────────────
        $publishedAt = $this->extractDate($item);

        // ─── Image ────────────────────────────────────────────────
        $imageUrl = $this->extractImage($item);

        // ─── Author ───────────────────────────────────────────────
        $author = $this->extractText($item, ['author', 'creator', 'dc:creator']);

        // ─── External ID ──────────────────────────────────────────
        $externalId = $this->extractText($item, ['guid', 'id']);

        return [
            'source_id'      => $source->id,
            'external_id'    => $externalId ? mb_substr($externalId, 0, 255) : null,
            'url'            => mb_substr($url, 0, 2048),
            'title'          => mb_substr(trim($title), 0, 255),
            'original_title' => mb_substr(trim($title), 0, 255),
            'description'    => $description,
            'author'         => $author ? mb_substr($author, 0, 255) : null,
            'image_url'      => $imageUrl ? mb_substr($imageUrl, 0, 2048) : null,
            'language'       => $source->language,
            'country_code'   => $source->country_code,
            'published_at'   => $publishedAt,
            'status'         => 'raw',
        ];
    }

    private function extractText(\SimpleXMLElement $item, array $fields): ?string
    {
        foreach ($fields as $field) {
            if (str_contains($field, ':')) {
                [$prefix, $name] = explode(':', $field);
                $namespaces = $item->getNamespaces(true);
                if (isset($namespaces[$prefix])) {
                    $children = $item->children($namespaces[$prefix]);
                    if (isset($children->$name) && (string) $children->$name !== '') {
                        return (string) $children->$name;
                    }
                }
            } elseif (isset($item->$field) && (string) $item->$field !== '') {
                return (string) $item->$field;
            }
        }

        return null;
    }

    private function extractUrl(\SimpleXMLElement $item): ?string
    {
        // Standard link
        if (isset($item->link) && (string) $item->link !== '') {
            return (string) $item->link;
        }

        // Atom link
        $atom = $item->children('http://www.w3.org/2005/Atom');
        if (isset($atom->link)) {
            foreach ($atom->link as $link) {
                $attrs = $link->attributes();
                if (! isset($attrs['rel']) || (string) $attrs['rel'] === 'alternate') {
                    return (string) ($attrs['href'] ?? '');
                }
            }
        }

        // CDATA link
        $namespaces = $item->getNamespaces(true);
        foreach ($namespaces as $prefix => $ns) {
            $children = $item->children($ns);
            if (isset($children->origLink)) {
                return (string) $children->origLink;
            }
        }

        return null;
    }

    private function extractDate(\SimpleXMLElement $item): ?string
    {
        $dateStr = $this->extractText($item, ['pubDate', 'published', 'updated', 'dc:date']);

        if (! $dateStr) {
            return now()->toDateTimeString();
        }

        try {
            return \Carbon\Carbon::parse($dateStr)->toDateTimeString();
        } catch (\Exception $e) {
            return now()->toDateTimeString();
        }
    }

    private function extractImage(\SimpleXMLElement $item): ?string
    {
        // Media namespace
        $media = $item->children('http://search.yahoo.com/mrss/');
        if (isset($media->content)) {
            $attrs = $media->content->attributes();
            if (isset($attrs['url'])) {
                return (string) $attrs['url'];
            }
        }

        if (isset($media->thumbnail)) {
            $attrs = $media->thumbnail->attributes();
            if (isset($attrs['url'])) {
                return (string) $attrs['url'];
            }
        }

        // Enclosure
        if (isset($item->enclosure)) {
            $attrs = $item->enclosure->attributes();
            $type = (string) ($attrs['type'] ?? '');
            if (str_starts_with($type, 'image/') && isset($attrs['url'])) {
                return (string) $attrs['url'];
            }
        }

        // Extract from description
        $description = (string) ($item->description ?? '');
        if ($description && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $description, $matches)) {
            return $matches[1];
        }

        return null;
    }
}