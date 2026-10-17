# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_API_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Get your token by calling POST /api/v1/auth/login.
