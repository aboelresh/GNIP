<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Models\UserSourcePreference;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $preferences = UserSourcePreference::where('user_id', $user->id)
            ->pluck('is_enabled', 'source_id');

        $sources = Source::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(fn ($source) => [
                'id'           => $source->id,
                'name'         => $source->name,
                'slug'         => $source->slug,
                'country_code' => $source->country_code,
                'language'     => $source->language,
                'bias'         => $source->bias,
                'website_url'  => $source->website_url,
                'is_enabled'   => $preferences->get($source->id, true),
            ]);

        return Inertia::render('Preferences/Sources', [
            'sources' => $sources,
        ]);
    }

    public function toggle(Request $request, Source $source): void
    {
        $validated = $request->validate([
            'is_enabled' => 'required|boolean',
        ]);

        UserSourcePreference::updateOrCreate(
            ['user_id' => $request->user()->id, 'source_id' => $source->id],
            ['is_enabled' => $validated['is_enabled']]
        );
    }

    public function reset(Request $request): void
    {
        UserSourcePreference::where('user_id', $request->user()->id)->delete();
    }
}