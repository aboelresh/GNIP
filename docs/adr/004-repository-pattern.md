\# ADR 004: Repository Pattern for Data Access



\## Status



Accepted



\## Context



The platform has complex duplicate detection logic for articles. An article is a duplicate if its URL has been seen before, or if its content hash matches an existing article from the same source within the same time window. This logic needs to be testable without a real database connection.



\## Decision



Use a Repository layer between the Service layer and the database. Controllers and Services depend on Repository interfaces, not on Eloquent models directly.



\## Reasons



The duplicate detection algorithm in `ArticleRepository` is the most critical piece of business logic in the feed pipeline. If it fails, the database fills with duplicate content and all downstream processing (clustering, briefings) produces degraded results.



Testing this logic requires controlling what the database returns. With direct Eloquent calls in the service layer, the only way to test is with a real database, which makes tests slow and environment-dependent.



The Repository pattern allows the duplicate detection logic to be tested with a mock that returns controlled responses. The test can verify that an article with a known content hash is correctly identified as a duplicate without touching the database.



The tradeoff is additional abstraction. For simple CRUD operations, the Repository adds indirection without benefit. In this codebase, only `ArticleRepository` uses the full pattern; other models use Eloquent directly through the service layer.



\## Consequences



`ArticleRepository` is the single point of control for article persistence. Any change to duplicate detection logic happens in one place. The interface makes the contract explicit: the repository must implement `findByUrl`, `findByContentHash`, and `store`, regardless of the underlying storage mechanism.

