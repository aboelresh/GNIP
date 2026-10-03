\# ADR 005: Laravel Sanctum over JWT



\## Status



Accepted



\## Context



The API requires token-based authentication. The two common approaches in the Laravel ecosystem are Laravel Sanctum (database-backed tokens) and JWT (stateless tokens).



\## Decision



Use Laravel Sanctum with personal access tokens.



\## Reasons



Sanctum tokens are stored in the database, which means they can be revoked immediately. A user who logs out has their token deleted; subsequent requests with that token fail at the database lookup, not at a token expiry check.



JWT tokens are stateless. Once issued, they are valid until they expire. Revoking a JWT requires a token blacklist, which reintroduces a database lookup and eliminates the main advantage of JWT.



For a news platform where users log in to access personalized features, immediate revocation on logout is the correct behavior. A user who logs out from a shared device should not have their session remain valid for hours.



Sanctum is also the official Laravel solution, which means it integrates with Laravel's authentication guards, middleware, and testing helpers without additional configuration. The `actingAs` helper in tests works directly with Sanctum tokens.



\## Consequences



Each API request requires a database query to validate the token. For the traffic levels this platform targets, this is not a concern. At higher scale, token caching with a short TTL would reduce database load without sacrificing revocability.



Token expiration is not configured in the current implementation. Adding a `tokenable` expiry or a scheduled cleanup of old tokens is a known improvement.

