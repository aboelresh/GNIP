\# ADR 001: MySQL over PostgreSQL



\## Status



Accepted



\## Context



The platform requires full-text search across Arabic, English, French, Italian, and Spanish content. It also needs JSON columns for multilingual data and reliable support for the deployment environments most common in the Arabic-speaking market.



\## Decision



Use MySQL 8 as the primary database.



\## Reasons



MySQL 8 introduced native FULLTEXT search with ngram parser support, which handles Arabic text without requiring external search infrastructure. The `JSON\_CONTAINS` and `JSON\_EXTRACT` functions added in MySQL 8 are sufficient for the multilingual metadata this platform stores.



PostgreSQL's full-text search is more powerful in general, but its Arabic language support requires additional configuration and extensions that complicate deployment. MySQL's simpler operational model also fits a portfolio project where the goal is demonstrating system design, not database administration.



The hosting environments most accessible to Arabic-language startups (shared hosting, basic VPS, managed MySQL on cloud providers) overwhelmingly support MySQL over PostgreSQL.



\## Consequences



FULLTEXT indexes are MySQL-specific, which means the test suite cannot use SQLite's in-memory database. A separate MySQL test database is required. This is documented in the README and configured in phpunit.xml.



If the platform were to scale to multi-language semantic search, migrating to PostgreSQL with pgvector or adding Elasticsearch would be the next step.

