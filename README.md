# Global News Intelligence Platform

A backend system that aggregates news from multiple international sources, clusters related articles into unified stories, and generates AI-powered summaries and briefings in five languages.

---

## What it does

The platform collects news articles from RSS feeds across different countries and editorial orientations, detects duplicates, groups articles covering the same event into a single story, and provides cross-source analysis showing what sources agree and disagree on.

The system runs entirely on a scheduled pipeline without manual intervention.

---

## Architecture

RSS Sources
|
Feed Fetcher (HTTP + XML Parser)
|
Normalization + Duplicate Detection
|
Article Storage (MySQL)
|
AI Classification + Summarization (Ollama / OpenAI)
|
Story Clustering (Jaccard Similarity)
|
Cross-Source Analysis
|
Briefing Generation (Daily / Weekly / Monthly)
|
REST API (Laravel)


The AI layer is provider-agnostic. The system tries providers in order and falls back automatically if one fails.

---

## Tech Stack

- PHP 8.2 / Laravel 11
- MySQL 8
- Ollama (local AI inference)
- Laravel Queues + Scheduler
- Laravel Sanctum (API authentication)

---

## Requirements

- PHP 8.2+
- Composer
- MySQL 8+
- Node.js 18+ (for frontend assets)
- Ollama (optional, for local AI)

---

## Installation

Clone the repository and install dependencies:

```bash
composer install
npm install
```

Copy the environment file:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gnip
DB_USERNAME=root
DB_PASSWORD=


Run migrations and seed initial data:

```bash
php artisan migrate
php artisan db:seed
```

---

## AI Configuration

The system supports multiple AI providers with automatic failover.

To use Ollama locally:

```bash
ollama pull llama3.2
ollama serve
```

Set in `.env`:

OLLAMA_BASE_URL=http://localhost:11434
OLLAMA_MODEL=llama3.2


To use OpenAI instead:

OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4o-mini


Provider order is configurable in `config/gnip.php`.

---

## Running the application

Start the development server:

```bash
php artisan serve
```

Start the queue worker:

```bash
php artisan queue:work
```

Start the scheduler:

```bash
php artisan schedule:work
```

---

## Manual pipeline execution

Fetch news from all active sources:

```bash
php artisan gnip:fetch-feeds
```

Fetch from a specific source:

```bash
php artisan gnip:fetch-feeds --source=bbc
```

Analyze raw articles with AI:

```bash
php artisan gnip:analyze-articles --limit=50
```

Cluster related articles into stories:

```bash
php artisan gnip:cluster-stories
```

Generate briefings:

```bash
php artisan gnip:generate-briefing daily
php artisan gnip:generate-briefing weekly
php artisan gnip:generate-briefing monthly
```

---

## Automated schedule

The scheduler runs the full pipeline automatically:

| Task | Frequency |
|------|-----------|
| Fetch feeds | Every 15 minutes |
| Analyze articles | Every 30 minutes |
| Cluster stories | Every hour |
| Daily briefing | 00:30 daily |
| Weekly briefing | Monday 01:00 |
| Monthly briefing | 1st of month 02:00 |

---

## API

Base URL: `/api/v1`

Authentication uses Bearer tokens via Laravel Sanctum.

### Auth

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | /auth/register | No |
| POST | /auth/login | No |
| GET | /auth/me | Yes |
| POST | /auth/logout | Yes |
| PUT | /auth/password | Yes |

### Content

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /dashboard | System stats |
| GET | /categories | List categories |
| GET | /sources | List sources |
| GET | /articles | List articles |
| GET | /articles/stats/overview | Article statistics |
| GET | /stories | List stories |
| GET | /stories/trending/list | Trending stories |
| GET | /briefings | List briefings |
| GET | /briefings/latest/{type} | Latest briefing by type |

### Filtering

Articles support filtering by `language`, `country`, `category`, `source`, `hours`, and free-text search via `q`.

Stories support filtering by `category`, `country`, and `evidence_level`.

### Rate limits

| Route group | Limit |
|-------------|-------|
| Auth routes | 10 requests per minute |
| Public routes | 30 per minute (unauthenticated), 120 (authenticated) |
| Heavy operations | 3 per minute (unauthenticated), 10 (authenticated) |

---

## Data model

Source
|
+-- Article (raw RSS item)
|
+-- Story (cluster of related articles)
|
+-- Claims (extracted assertions)
|
+-- Entities (persons, countries, organizations)
|
+-- Videos (related video content)
|
+-- Briefing (periodic summary)


Evidence levels are calculated based on the number of independent sources, degree of agreement, and presence of primary sources.

---

## Languages

The platform supports Arabic, English, French, Italian, and Spanish across all content, summaries, and briefings. Arabic is treated as the primary language for display.

---

## Sources

Active sources span wire agencies, TV channels, newspapers, and digital outlets across multiple countries and editorial orientations. Source diversity is a core design principle. The system tracks reliability scores and editorial bias for each source.

---

## Project structure

app/
Console/Commands/ Artisan commands for pipeline steps
Http/Controllers/Api/ REST API controllers
Http/Controllers/Web/ Inertia web controllers
Jobs/Feed/ Background jobs for feed fetching
Models/ Eloquent models
Repositories/ Data access layer
Services/AI/ AI provider abstraction
Services/Analysis/ Story clustering and briefing generation
Services/Feed/ RSS feed fetching and parsing

database/
migrations/ Database schema
seeders/ Initial categories and sources

routes/
api.php API routes
web.php Web routes
console.php Scheduled tasks


---

## Environment variables

See `.env.example` for all available configuration options.

---

## Docker

The application includes a complete Docker setup with separate containers for each concern.

### Services

- `app` — PHP-FPM application server
- `nginx` — Web server and reverse proxy
- `db` — MySQL 8 database
- `queue` — Queue worker for background jobs
- `scheduler` — Runs the Laravel scheduler every minute

### Running with Docker

Copy the environment file and configure it:

```bash
cp .env.example .env
```

Build and start all services:

```bash
docker-compose up -d --build
```

Run migrations and seed initial data:

```bash
docker-compose exec app php artisan migrate --seed
```

The application will be available at `http://localhost:8080`.

### Useful commands

```bash
# View logs
docker-compose logs -f app

# Run artisan commands
docker-compose exec app php artisan gnip:fetch-feeds

# Run tests
docker-compose exec app php artisan test

# Stop all services
docker-compose down

# Stop and remove volumes (deletes database)
docker-compose down -v
```

### Why separate containers for queue and scheduler?

Each process has a single responsibility. The queue worker runs continuously processing jobs. The scheduler wakes up every 60 seconds to dispatch scheduled tasks. Separating them means a failure in one does not affect the other, and each can be scaled independently.

---

## Architecture decisions

Key technical decisions and their reasoning are documented in `docs/adr/`. Each record explains the context, the decision, the alternatives considered, and the consequences.

- [ADR 001](docs/adr/001-mysql-over-postgresql.md) — Why MySQL over PostgreSQL
- [ADR 002](docs/adr/002-queue-for-ai-processing.md) — Why AI processing runs in a background queue
- [ADR 003](docs/adr/003-jaccard-similarity-clustering.md) — Why Jaccard similarity for story clustering
- [ADR 004](docs/adr/004-repository-pattern.md) — Why the Repository pattern for article data access
- [ADR 005](docs/adr/005-sanctum-over-jwt.md) — Why Sanctum over JWT

---

## Testing

A Postman collection is included at `postman_collection.json`. Import it into Postman and set the `base_url` environment variable to `http://127.0.0.1:8000/api/v1`.