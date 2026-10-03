\# ADR 002: Background Queue for AI Processing



\## Status



Accepted



\## Context



The platform uses AI to classify and summarize articles. Each AI call can take between 5 and 120 seconds depending on the provider and model. The platform fetches up to 50 articles every 30 minutes across multiple sources.



\## Decision



AI processing runs as background jobs via Laravel Queues, not synchronously during feed fetching.



\## Reasons



Running AI calls synchronously during feed fetching would block the fetch process for minutes per batch. A 50-article batch with a 30-second average per call would take 25 minutes, which is longer than the 30-minute fetch interval. This would cause fetches to pile up and eventually exhaust available workers.



Moving AI processing to a queue separates concerns cleanly: feed fetching stores raw articles immediately, and AI enrichment happens asynchronously. This means the platform always has fresh raw content even if the AI provider is slow or temporarily unavailable.



The queue also gives us retry logic for free. If an AI call fails, the job retries up to 3 times with backoff. Without a queue, a failed API call would silently drop the article from processing.



\## Consequences



Articles exist in two states: `raw` (fetched but not analyzed) and `processed` (AI-enriched). The API exposes both and filters by status. The dashboard shows the split between raw and processed counts, which makes the pipeline state visible.



A separate queue worker process is required. In Docker this runs as a dedicated container. In production it would run as a supervised process.

