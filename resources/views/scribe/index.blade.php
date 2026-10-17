<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>GNIP API</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8080";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.11.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.11.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-auth-register">
                                <a href="#endpoints-POSTapi-v1-auth-register">POST api/v1/auth/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-auth-login">
                                <a href="#endpoints-POSTapi-v1-auth-login">POST api/v1/auth/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-health">
                                <a href="#endpoints-GETapi-v1-health">GET api/v1/health</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-categories">
                                <a href="#endpoints-GETapi-v1-categories">GET api/v1/categories</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-categories--category_id-">
                                <a href="#endpoints-GETapi-v1-categories--category_id-">GET api/v1/categories/{category_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-stories">
                                <a href="#endpoints-GETapi-v1-stories">GET api/v1/stories</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-stories-trending-list">
                                <a href="#endpoints-GETapi-v1-stories-trending-list">GET api/v1/stories/trending/list</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-stories--story_id-">
                                <a href="#endpoints-GETapi-v1-stories--story_id-">GET api/v1/stories/{story_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-articles">
                                <a href="#endpoints-GETapi-v1-articles">GET api/v1/articles</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-articles-stats-overview">
                                <a href="#endpoints-GETapi-v1-articles-stats-overview">GET api/v1/articles/stats/overview</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-articles--article_id-">
                                <a href="#endpoints-GETapi-v1-articles--article_id-">GET api/v1/articles/{article_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-briefings">
                                <a href="#endpoints-GETapi-v1-briefings">GET api/v1/briefings</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-briefings-latest--type-">
                                <a href="#endpoints-GETapi-v1-briefings-latest--type-">GET api/v1/briefings/latest/{type}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-briefings--briefing_id-">
                                <a href="#endpoints-GETapi-v1-briefings--briefing_id-">GET api/v1/briefings/{briefing_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-dashboard">
                                <a href="#endpoints-GETapi-v1-dashboard">GET api/v1/dashboard</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-sources">
                                <a href="#endpoints-GETapi-v1-sources">GET api/v1/sources</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-sources--source_id-">
                                <a href="#endpoints-GETapi-v1-sources--source_id-">GET api/v1/sources/{source_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-auth-logout">
                                <a href="#endpoints-POSTapi-v1-auth-logout">POST api/v1/auth/logout</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-auth-me">
                                <a href="#endpoints-GETapi-v1-auth-me">GET api/v1/auth/me</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-v1-auth-password">
                                <a href="#endpoints-PUTapi-v1-auth-password">PUT api/v1/auth/password</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-v1-preferences-sources">
                                <a href="#endpoints-GETapi-v1-preferences-sources">Return all sources with the authenticated user's preference for each.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-v1-preferences-sources--source_id-">
                                <a href="#endpoints-PUTapi-v1-preferences-sources--source_id-">Toggle a single source on or off.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-v1-preferences-sources">
                                <a href="#endpoints-PUTapi-v1-preferences-sources">Bulk update all source preferences at once.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-v1-preferences-sources">
                                <a href="#endpoints-DELETEapi-v1-preferences-sources">Reset all preferences to enabled (default state).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-sources--source_id--fetch">
                                <a href="#endpoints-POSTapi-v1-sources--source_id--fetch">POST api/v1/sources/{source_id}/fetch</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-v1-articles--article_id--analyze">
                                <a href="#endpoints-POSTapi-v1-articles--article_id--analyze">POST api/v1/articles/{article_id}/analyze</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: October 16, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Global News Intelligence Platform — REST API for news aggregation, story clustering, and AI-powered briefings.</p>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8080</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_API_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Get your token by calling POST /api/v1/auth/login.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-POSTapi-v1-auth-register">POST api/v1/auth/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-auth-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8080/api/v1/auth/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"name\": \"vmqeopfuudtdsufvyvddq\",
    \"email\": \"kunde.eloisa@example.com\",
    \"password\": \"4[*UyPJ\\\"}6\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/auth/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "vmqeopfuudtdsufvyvddq",
    "email": "kunde.eloisa@example.com",
    "password": "4[*UyPJ\"}6"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-register">
</span>
<span id="execution-results-POSTapi-v1-auth-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-register" data-method="POST"
      data-path="api/v1/auth/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-register"
                    onclick="tryItOut('POSTapi-v1-auth-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-register"
                    onclick="cancelTryOut('POSTapi-v1-auth-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-auth-register"
               value="vmqeopfuudtdsufvyvddq"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>vmqeopfuudtdsufvyvddq</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-register"
               value="kunde.eloisa@example.com"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>kunde.eloisa@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-register"
               value="4[*UyPJ"}6"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>4[*UyPJ"}6</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-v1-auth-login">POST api/v1/auth/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-auth-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8080/api/v1/auth/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"qkunze@example.com\",
    \"password\": \"O[2UZ5ij-e\\/dl4m{o,\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/auth/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "qkunze@example.com",
    "password": "O[2UZ5ij-e\/dl4m{o,"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-login">
</span>
<span id="execution-results-POSTapi-v1-auth-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-login" data-method="POST"
      data-path="api/v1/auth/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-login"
                    onclick="tryItOut('POSTapi-v1-auth-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-login"
                    onclick="cancelTryOut('POSTapi-v1-auth-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-auth-login"
               value="qkunze@example.com"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>qkunze@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-v1-auth-login"
               value="O[2UZ5ij-e/dl4m{o,"
               data-component="body">
    <br>
<p>Example: <code>O[2UZ5ij-e/dl4m{o,</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-health">GET api/v1/health</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-health">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/health" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/health"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-health">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;timestamp&quot;: &quot;2026-10-16T20:59:24+00:00&quot;,
    &quot;version&quot;: &quot;1.0.0&quot;,
    &quot;checks&quot;: {
        &quot;database&quot;: &quot;ok&quot;,
        &quot;cache&quot;: &quot;ok&quot;,
        &quot;queue&quot;: {
            &quot;status&quot;: &quot;ok&quot;,
            &quot;pending&quot;: 0,
            &quot;failed&quot;: 0
        },
        &quot;ai&quot;: {
            &quot;status&quot;: &quot;unavailable&quot;,
            &quot;providers&quot;: []
        },
        &quot;stats&quot;: {
            &quot;articles&quot;: 1360,
            &quot;stories&quot;: 147,
            &quot;sources&quot;: 33
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-health" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-health"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-health"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-health" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-health">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-health" data-method="GET"
      data-path="api/v1/health"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-health', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-health"
                    onclick="tryItOut('GETapi-v1-health');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-health"
                    onclick="cancelTryOut('GETapi-v1-health');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-health"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/health</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-health"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-categories">GET api/v1/categories</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-categories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/categories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/categories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-categories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 29
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;politics&quot;,
            &quot;name&quot;: &quot;Politics&quot;,
            &quot;description&quot;: &quot;Political news and government affairs&quot;,
            &quot;icon&quot;: &quot;🏛️&quot;,
            &quot;color&quot;: &quot;#3B82F6&quot;,
            &quot;order&quot;: 1
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;conflicts&quot;,
            &quot;name&quot;: &quot;Military &amp; Conflicts&quot;,
            &quot;description&quot;: &quot;Military operations and armed conflicts&quot;,
            &quot;icon&quot;: &quot;⚔️&quot;,
            &quot;color&quot;: &quot;#EF4444&quot;,
            &quot;order&quot;: 2
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;economy&quot;,
            &quot;name&quot;: &quot;Economy&quot;,
            &quot;description&quot;: &quot;Economic news and financial markets&quot;,
            &quot;icon&quot;: &quot;📈&quot;,
            &quot;color&quot;: &quot;#10B981&quot;,
            &quot;order&quot;: 3
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;technology&quot;,
            &quot;name&quot;: &quot;Technology&quot;,
            &quot;description&quot;: &quot;Technology and innovation news&quot;,
            &quot;icon&quot;: &quot;💻&quot;,
            &quot;color&quot;: &quot;#8B5CF6&quot;,
            &quot;order&quot;: 4
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;science&quot;,
            &quot;name&quot;: &quot;Science&quot;,
            &quot;description&quot;: &quot;Scientific discoveries and research&quot;,
            &quot;icon&quot;: &quot;🔬&quot;,
            &quot;color&quot;: &quot;#06B6D4&quot;,
            &quot;order&quot;: 5
        },
        {
            &quot;id&quot;: 6,
            &quot;slug&quot;: &quot;health&quot;,
            &quot;name&quot;: &quot;Health&quot;,
            &quot;description&quot;: &quot;Health and medical news&quot;,
            &quot;icon&quot;: &quot;🏥&quot;,
            &quot;color&quot;: &quot;#F59E0B&quot;,
            &quot;order&quot;: 6
        },
        {
            &quot;id&quot;: 7,
            &quot;slug&quot;: &quot;environment&quot;,
            &quot;name&quot;: &quot;Environment&quot;,
            &quot;description&quot;: &quot;Environmental and climate news&quot;,
            &quot;icon&quot;: &quot;🌍&quot;,
            &quot;color&quot;: &quot;#84CC16&quot;,
            &quot;order&quot;: 7
        },
        {
            &quot;id&quot;: 8,
            &quot;slug&quot;: &quot;sports&quot;,
            &quot;name&quot;: &quot;Sports&quot;,
            &quot;description&quot;: &quot;Sports news and results&quot;,
            &quot;icon&quot;: &quot;⚽&quot;,
            &quot;color&quot;: &quot;#F97316&quot;,
            &quot;order&quot;: 8
        },
        {
            &quot;id&quot;: 9,
            &quot;slug&quot;: &quot;business&quot;,
            &quot;name&quot;: &quot;Business&quot;,
            &quot;description&quot;: &quot;Business and corporate news&quot;,
            &quot;icon&quot;: &quot;💼&quot;,
            &quot;color&quot;: &quot;#6B7280&quot;,
            &quot;order&quot;: 9
        },
        {
            &quot;id&quot;: 10,
            &quot;slug&quot;: &quot;international&quot;,
            &quot;name&quot;: &quot;International Affairs&quot;,
            &quot;description&quot;: &quot;International relations and diplomacy&quot;,
            &quot;icon&quot;: &quot;🌐&quot;,
            &quot;color&quot;: &quot;#EC4899&quot;,
            &quot;order&quot;: 10
        }
    ],
    &quot;meta&quot;: {
        &quot;locale&quot;: &quot;en&quot;,
        &quot;total&quot;: 10,
        &quot;cached&quot;: true
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-categories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-categories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-categories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-categories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-categories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-categories" data-method="GET"
      data-path="api/v1/categories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-categories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-categories"
                    onclick="tryItOut('GETapi-v1-categories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-categories"
                    onclick="cancelTryOut('GETapi-v1-categories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-categories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/categories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-categories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-categories--category_id-">GET api/v1/categories/{category_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-categories--category_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/categories/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/categories/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-categories--category_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 28
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;slug&quot;: &quot;politics&quot;,
        &quot;name&quot;: &quot;Politics&quot;,
        &quot;description&quot;: &quot;Political news and government affairs&quot;,
        &quot;icon&quot;: &quot;🏛️&quot;,
        &quot;color&quot;: &quot;#3B82F6&quot;,
        &quot;articles_count&quot;: 126,
        &quot;stories_count&quot;: 123
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-categories--category_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-categories--category_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-categories--category_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-categories--category_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-categories--category_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-categories--category_id-" data-method="GET"
      data-path="api/v1/categories/{category_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-categories--category_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-categories--category_id-"
                    onclick="tryItOut('GETapi-v1-categories--category_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-categories--category_id-"
                    onclick="cancelTryOut('GETapi-v1-categories--category_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-categories--category_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/categories/{category_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-categories--category_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-categories--category_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>category_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="category_id"                data-endpoint="GETapi-v1-categories--category_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the category. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-stories">GET api/v1/stories</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-stories">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/stories" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/stories"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-stories">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 27
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;slug&quot;: &quot;serie-a-in-campo-inter-napoli-1-2-diretta&quot;,
            &quot;title&quot;: &quot;Serie A: in campo Inter-Napoli 1-2 DIRETTA&quot;,
            &quot;summary&quot;: &quot;Ospiti avanti con Politano e Hojlund&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:21:27.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:28:41.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Sports&quot;,
                &quot;slug&quot;: &quot;sports&quot;,
                &quot;icon&quot;: &quot;⚽&quot;,
                &quot;color&quot;: &quot;#F97316&quot;
            }
        },
        {
            &quot;id&quot;: 2,
            &quot;slug&quot;: &quot;us-pentagon-submits-military-officers-to-polygraph-tests-amid-leaks-investigation&quot;,
            &quot;title&quot;: &quot;US Pentagon Submits Military Officers to Polygraph Tests Amid Leaks Investigation&quot;,
            &quot;summary&quot;: &quot;Une cinquantaine de membres de l&rsquo;&eacute;tat-major ont &eacute;t&eacute; interrog&eacute;s au polygraphe pour identifier la source d&rsquo;une fuite sur une possible p&eacute;nurie de munitions am&eacute;ricaines.&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;fr&quot;
            ],
            &quot;image_url&quot;: &quot;https://img.lemde.fr/2026/09/05/445/0/2754/1377/644/322/60/0/c8bd925_upload-1-tj8rbj5z61px-000-b4jv8t3.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:17:10.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:29:05.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 3,
            &quot;slug&quot;: &quot;incappucciati-invadono-dover-contro-i-migranti&quot;,
            &quot;title&quot;: &quot;Incappucciati invadono Dover contro i migranti&quot;,
            &quot;summary&quot;: &quot; Farage &#039;fermeremo le barche&#039;. Il leader di Reform tenta il rilancio: &#039;Se non vinciamo le elezioni sar&agrave; irreversibile il declino inglese&#039; &quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:17:09.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:30:41.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 4,
            &quot;slug&quot;: &quot;ucraina-in-corso-lincontro-di-putin-con-witkoff-e-kushner&quot;,
            &quot;title&quot;: &quot;Ucraina, in corso l&#039;incontro di Putin con Witkoff e Kushner&quot;,
            &quot;summary&quot;: &quot;Gi inviati americani Steve Witkoff e Jared Kushner in Russia&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:12:53.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:31:02.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 5,
            &quot;slug&quot;: &quot;russia-ukraine-talks-poutine-meets-with-us-envoy-team&quot;,
            &quot;title&quot;: &quot;Russia-Ukraine Talks: Poutine Meets with US Envoy Team&quot;,
            &quot;summary&quot;: &quot;Donald Trump n&rsquo;a pas pr&eacute;cis&eacute; si la proposition dont ses &eacute;missaires sont porteurs impliquait une cession de territoire de la part de l&rsquo;Ukraine, comme il l&rsquo;avait laiss&eacute; entendre auparavant. Les deux hommes doivent rencontrer dimanche Volodymyr Zelensky, &agrave; Kiev, pour la premi&egrave;re fois depuis le d&eacute;but de leur travail de m&eacute;diateur.&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;fr&quot;
            ],
            &quot;image_url&quot;: &quot;https://img.lemde.fr/2026/09/05/161/0/3530/1765/644/322/60/0/a78f564_ftp-1-qbftbcem9vj2-2026-09-05t162917z-1623591992-rc24dna8apcq-rtrmadp-3-ukraine-crisis-russia-usa.JPG&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:12:40.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:31:20.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 6,
            &quot;slug&quot;: &quot;usa-colpiscono-tre-petroliere-iraniane-missile-vicino-kharg&quot;,
            &quot;title&quot;: &quot;Usa colpiscono tre petroliere iraniane, missile vicino Kharg&quot;,
            &quot;summary&quot;: &quot;Ritorsione per razzi su navi. Tycoon: &#039;Solo Attacchi, briciole&#039;. Piano per il dopo guerra &quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:03:52.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:31:40.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 7,
            &quot;slug&quot;: &quot;la-procura-di-roma-indaga-sugli-italiani-negli-epstein-file&quot;,
            &quot;title&quot;: &quot;La procura di Roma indaga sugli italiani negli Epstein file&quot;,
            &quot;summary&quot;: &quot;Fascicolo contro ignoti, rogatoria su atti riservati. Differenza Donna: &#039;passo importante&#039; &quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:02:59.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:33:14.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 8,
            &quot;slug&quot;: &quot;famiglia-nel-bosco-la-decisione-ci-spezza-il-cuore-faremo-ricorso&quot;,
            &quot;title&quot;: &quot;Famiglia nel bosco: &#039;La decisione ci spezza il cuore, faremo ricorso&#039;&quot;,
            &quot;summary&quot;: &quot;Video dei genitori dopo la decisione del tribunale. Pillon: &#039;inerzia dei servizi sociali&#039;&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:01:59.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:34:05.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 9,
            &quot;slug&quot;: &quot;incidente-al-rally-1000-miglia-spettatore-muore-investito&quot;,
            &quot;title&quot;: &quot;Incidente al Rally 1000 Miglia, spettatore muore investito&quot;,
            &quot;summary&quot;: &quot;Vittima un 63enne di Torino, la direzione di gara ha sospeso la manifestazione&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T19:00:42.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:35:10.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 10,
            &quot;slug&quot;: &quot;hamilton-takes-fourth-at-monza-despite-controversy&quot;,
            &quot;title&quot;: &quot;English&quot;,
            &quot;summary&quot;: &quot;Charles Leclerc secured third place despite a penalty for his teammate, Daniel Ricciardo, while Pierre Gasly took pole position at the Italian Grand Prix. Meanwhile, Lewis Hamilton finished fourth, amidst controversy surrounding the penalty given to Ricciardo.&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:48:06.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:35:28.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Sports&quot;,
                &quot;slug&quot;: &quot;sports&quot;,
                &quot;icon&quot;: &quot;⚽&quot;,
                &quot;color&quot;: &quot;#F97316&quot;
            }
        },
        {
            &quot;id&quot;: 11,
            &quot;slug&quot;: &quot;segregata-dal-marito-in-egitto-salva-allarrivo-allaeroporto&quot;,
            &quot;title&quot;: &quot;Segregata dal marito in Egitto, salva all&#039;arrivo all&#039;aeroporto&quot;,
            &quot;summary&quot;: &quot;Ragusana riconosciuta dalla Polaria a Palermo mostra segno convenzionale d&#039;aiuto&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:37:07.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:37:03.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 12,
            &quot;slug&quot;: &quot;f1-saetta-mcqueen-compie-un-giro-donore-a-monza-la-safety-car-si-veste-cars&quot;,
            &quot;title&quot;: &quot;F1: Saetta McQueen compie un giro d&#039;onore a Monza, la Safety Car si veste \&quot;Cars\&quot;&quot;,
            &quot;summary&quot;: &quot;Disney e Formula 1 celebrano all&#039;Autodromo anniversario del celebre franchise Pixar&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:31:21.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:38:38.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Sports&quot;,
                &quot;slug&quot;: &quot;sports&quot;,
                &quot;icon&quot;: &quot;⚽&quot;,
                &quot;color&quot;: &quot;#F97316&quot;
            }
        },
        {
            &quot;id&quot;: 13,
            &quot;slug&quot;: &quot;scintille-tra-vannacci-e-monti-a-cernobbio-combattero-la-sua-retorica-fascista-il-leader-di-fnv-accuse-ridicole&quot;,
            &quot;title&quot;: &quot;Scintille tra Vannacci e Monti a Cernobbio: &#039;Combatter&ograve; la sua retorica fascista&#039;. Il leader di FnV: &#039;Accuse ridicole&#039;&quot;,
            &quot;summary&quot;: &quot;Vannacci: &#039;Non tutti scalpitano per integrarsi nell&#039;Unione europea, in Italia s&igrave; al Reborn&#039;&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:13:11.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:40:12.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 14,
            &quot;slug&quot;: &quot;italian-talent-exodus-costs-11-billion-calderones-20-share&quot;,
            &quot;title&quot;: &quot;Italian Talent Exodus Costs $11 Billion, Calderone&#039;s 20% Share&quot;,
            &quot;summary&quot;: &quot;Studio a Cernobbio. La ministra, dati cambiati, ora crescono i posti fissi&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:12:49.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:40:36.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 15,
            &quot;slug&quot;: &quot;un-diamante-dalle-ceneri-di-un-sacerdote-per-riflettere-la-luce-di-dio&quot;,
            &quot;title&quot;: &quot;Un diamante dalle ceneri di un sacerdote, &#039;per riflettere la luce di Dio&#039;&quot;,
            &quot;summary&quot;: &quot;La richiesta del prete marchigiano, morto nel 2025, in un video-testamento&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T18:10:55.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:42:15.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 16,
            &quot;slug&quot;: &quot;chinese-citizen-rescued-from-tunnel-burial-in-nepal&quot;,
            &quot;title&quot;: &quot;Chinese Citizen Rescued from Tunnel Burial in Nepal&quot;,
            &quot;summary&quot;: &quot;Esercito, &#039;sopravvissuto nella condotta di una centrale idroelettrica&#039;&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T17:59:10.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:42:39.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 17,
            &quot;slug&quot;: &quot;il-padre-di-lorena-la-politica-sia-unita-contro-la-violenza-meloni-raccoglie-lappello-ogni-donna-uccisa-e-una-sconfitta-per-tutti&quot;,
            &quot;title&quot;: &quot;Il padre di Lorena: &#039;La politica sia unita contro la violenza&#039;. Meloni raccoglie l&#039;appello: &#039;Ogni donna uccisa &egrave; una sconfitta per tutti&#039;&quot;,
            &quot;summary&quot;: &quot;&#039;Votate all&#039;unanimit&agrave; le norme e lavorate su scuole e centri antiviolenza&#039;&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T17:53:37.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:44:44.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 18,
            &quot;slug&quot;: &quot;us-destroys-three-iranian-oil-tankers-in-response-to-attacks-on-us-vessels-in-persian-gulf&quot;,
            &quot;title&quot;: &quot;US Destroys Three Iranian Oil Tankers in Response to Attacks on US Vessels in Persian Gulf&quot;,
            &quot;summary&quot;: &quot;Un porte-avions et un destroyer am&eacute;ricains &laquo;&nbsp;ont &eacute;chapp&eacute; &agrave; de multiples attaques iraniennes non provoqu&eacute;es&nbsp;&raquo;, selon l&rsquo;arm&eacute;e am&eacute;ricaine.&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;fr&quot;
            ],
            &quot;image_url&quot;: &quot;https://img.lemde.fr/2026/09/05/71/0/1730/865/644/322/60/0/e425269_ftp-1-dxsvmy5yxi9q-5003234-01-06.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T17:50:33.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:45:13.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 19,
            &quot;slug&quot;: &quot;riaperte-le-indagini-sui-delitti-del-mostro-di-modena&quot;,
            &quot;title&quot;: &quot;Riaperte le indagini sui delitti del &#039;mostro di Modena&#039;&quot;,
            &quot;summary&quot;: &quot;Almeno otto donne uccise dal 1985, accertamenti sui reperti e sugli atti dell&#039;epoca&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;IT&quot;
            ],
            &quot;languages&quot;: [
                &quot;it&quot;
            ],
            &quot;image_url&quot;: null,
            &quot;first_reported_at&quot;: &quot;2026-09-05T17:34:02.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:45:34.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 20,
            &quot;slug&quot;: &quot;on-sadapte-a-la-situation-a-laval-les-terrains-de-football-a-lepreuve-de-la-secheresse-et-du-changement-climatique&quot;,
            &quot;title&quot;: &quot;&laquo;&nbsp;On s&rsquo;adapte &agrave; la situation&nbsp;&raquo;&nbsp;: &agrave; Laval, les terrains de football &agrave; l&rsquo;&eacute;preuve de la s&eacute;cheresse et du changement climatique&quot;,
            &quot;summary&quot;: &quot;Avec les &eacute;pisodes caniculaires de l&rsquo;&eacute;t&eacute;, la Mayenne a instaur&eacute; des restrictions d&rsquo;usage de l&rsquo;eau. Si le Stade lavallois, pensionnaire de Ligue&nbsp;2, est parvenu &agrave; pr&eacute;server sa pelouse, le terrain de l&rsquo;US&nbsp;Laval, club amateur, reste impraticable.&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 20,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 1,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: false,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;fr&quot;
            ],
            &quot;image_url&quot;: &quot;https://img.lemde.fr/2026/09/05/732/0/4256/2128/644/322/60/0/8de8e37_upload-1-5vsps142zh10-vfeo-laval-040926-1471.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T17:30:01.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:47:15.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Sports&quot;,
                &quot;slug&quot;: &quot;sports&quot;,
                &quot;icon&quot;: &quot;⚽&quot;,
                &quot;color&quot;: &quot;#F97316&quot;
            }
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 147,
        &quot;per_page&quot;: 20,
        &quot;current_page&quot;: 1,
        &quot;last_page&quot;: 8
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-stories" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-stories"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-stories"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-stories" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-stories">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-stories" data-method="GET"
      data-path="api/v1/stories"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-stories', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-stories"
                    onclick="tryItOut('GETapi-v1-stories');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-stories"
                    onclick="cancelTryOut('GETapi-v1-stories');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-stories"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/stories</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-stories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-stories"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-stories-trending-list">GET api/v1/stories/trending/list</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-stories-trending-list">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/stories/trending/list" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/stories/trending/list"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-stories-trending-list">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 26
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 35,
            &quot;slug&quot;: &quot;cessez-le-feu-temporaire-a-kiev-pendant-trois-jours-alors-que-les-emissaires-americains-sy-rendent&quot;,
            &quot;title&quot;: &quot;Cessez-le-feu temporaire &agrave; Kiev pendant trois jours alors que les &eacute;missaires am&eacute;ricains s&#039;y rendent&quot;,
            &quot;summary&quot;: &quot;\nLe pr&eacute;sident russe Vladimir Poutine a ordonn&eacute;, samedi, de cesser les frappes sur Kiev pendant trois jours, alors que les Am&eacute;ricains Steve Witkoff et Jared Kushner doivent s&#039;y rendre. Les deux &eacute;missaires du pr&eacute;sident am&eacute;ricain ont atterri &agrave; Moscou avec un plan visant &agrave; mettre fin &agrave; plus de quatre ans de guerre en Ukraine.\n&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 25,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 2,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: true,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;fr&quot;
            ],
            &quot;image_url&quot;: &quot;https://s.france24.com/media/display/e4877664-a944-11f1-ab58-005056bfb2b6/w:1024/p:16x9/FR-20260905-180444-180832-CS.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T14:56:54.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T22:01:08.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 22,
            &quot;slug&quot;: &quot;us-envoys-meet-putin-in-moscow-for-ukraine-talks&quot;,
            &quot;title&quot;: &quot;US envoys meet Putin in Moscow for Ukraine talks&quot;,
            &quot;summary&quot;: &quot;President Trump says his envoys Steve Witkoff and Jared Kushner are \&quot;bringing with them a proposal to end the war\&quot;.&quot;,
            &quot;evidence_level&quot;: &quot;moderate&quot;,
            &quot;evidence_score&quot;: 40,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 2,
            &quot;articles_count&quot;: 2,
            &quot;independent_sources_count&quot;: 2,
            &quot;is_trending&quot;: true,
            &quot;countries&quot;: [
                &quot;GB&quot;,
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;en&quot;
            ],
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/5833/live/8e0ff630-a94e-11f1-ae8c-2528accc9a1a.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T16:14:00.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:48:29.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        },
        {
            &quot;id&quot;: 21,
            &quot;slug&quot;: &quot;us-diplomat-blames-israel-for-palestinian-protection-in-west-bank&quot;,
            &quot;title&quot;: &quot;US Diplomat Blames Israel for Palestinian Protection in West Bank&quot;,
            &quot;summary&quot;: &quot;\nأجرى السفير الأمريكي في إسرائيل&nbsp;مايك هاكابي السبت زيارة إلى&nbsp;بلدة ترمسعيا قرب رام الله بوسط الضفة الغربية المحتلة، التي يحمل معظم سكانها الجنسية الأمريكية، وقال إنه يريد الاستماع إلى \&quot;شكاواهم المشروعة\&quot;، بعدما تصاعدت حدة هجمات المستوطنين على الفلسطينيين.\n&quot;,
            &quot;evidence_level&quot;: &quot;low&quot;,
            &quot;evidence_score&quot;: 25,
            &quot;importance_score&quot;: 50,
            &quot;sources_count&quot;: 1,
            &quot;articles_count&quot;: 2,
            &quot;independent_sources_count&quot;: 1,
            &quot;is_trending&quot;: true,
            &quot;countries&quot;: [
                &quot;FR&quot;
            ],
            &quot;languages&quot;: [
                &quot;ar&quot;
            ],
            &quot;image_url&quot;: &quot;https://s.france24.com/media/display/db43d23e-a924-11f1-b6c3-005056a97e36/w:1024/p:16x9/2026-09-05T065615Z-1057574229-RC2UCNAUVX83-RTRMADP-3-ISRAEL-PALESTINIANS-SETTLERS-USA.jpg&quot;,
            &quot;first_reported_at&quot;: &quot;2026-09-05T15:48:29.000000Z&quot;,
            &quot;last_updated_at&quot;: &quot;2026-09-05T21:47:42.000000Z&quot;,
            &quot;category&quot;: {
                &quot;name&quot;: &quot;Politics&quot;,
                &quot;slug&quot;: &quot;politics&quot;,
                &quot;icon&quot;: &quot;🏛️&quot;,
                &quot;color&quot;: &quot;#3B82F6&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-stories-trending-list" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-stories-trending-list"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-stories-trending-list"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-stories-trending-list" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-stories-trending-list">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-stories-trending-list" data-method="GET"
      data-path="api/v1/stories/trending/list"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-stories-trending-list', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-stories-trending-list"
                    onclick="tryItOut('GETapi-v1-stories-trending-list');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-stories-trending-list"
                    onclick="cancelTryOut('GETapi-v1-stories-trending-list');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-stories-trending-list"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/stories/trending/list</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-stories-trending-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-stories-trending-list"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-stories--story_id-">GET api/v1/stories/{story_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-stories--story_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/stories/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/stories/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-stories--story_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 25
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;slug&quot;: &quot;serie-a-in-campo-inter-napoli-1-2-diretta&quot;,
        &quot;title&quot;: &quot;Serie A: in campo Inter-Napoli 1-2 DIRETTA&quot;,
        &quot;summary&quot;: &quot;Ospiti avanti con Politano e Hojlund&quot;,
        &quot;evidence_level&quot;: &quot;low&quot;,
        &quot;evidence_score&quot;: 20,
        &quot;importance_score&quot;: 50,
        &quot;sources_count&quot;: 1,
        &quot;articles_count&quot;: 1,
        &quot;independent_sources_count&quot;: 1,
        &quot;is_trending&quot;: false,
        &quot;countries&quot;: [
            &quot;IT&quot;
        ],
        &quot;languages&quot;: [
            &quot;it&quot;
        ],
        &quot;image_url&quot;: null,
        &quot;first_reported_at&quot;: &quot;2026-09-05T19:21:27.000000Z&quot;,
        &quot;last_updated_at&quot;: &quot;2026-09-05T21:28:41.000000Z&quot;,
        &quot;category&quot;: {
            &quot;name&quot;: &quot;Sports&quot;,
            &quot;slug&quot;: &quot;sports&quot;,
            &quot;icon&quot;: &quot;⚽&quot;,
            &quot;color&quot;: &quot;#F97316&quot;
        },
        &quot;what_happened&quot;: null,
        &quot;what_changed&quot;: null,
        &quot;sources_agree&quot;: null,
        &quot;sources_disagree&quot;: null,
        &quot;unconfirmed_claims&quot;: null,
        &quot;tags&quot;: null,
        &quot;articles&quot;: [
            {
                &quot;id&quot;: 298,
                &quot;title&quot;: &quot;Serie A: in campo Inter-Napoli 1-2 DIRETTA&quot;,
                &quot;url&quot;: &quot;https://www.ansa.it/sito/notizie/sport/calcio/2026/09/05/serie-a-in-campo-inter-napoli-0-0-diretta_f0786866-9862-46fc-b0c1-29d14f19c86c.html&quot;,
                &quot;source&quot;: &quot;ANSA&quot;,
                &quot;published_at&quot;: &quot;2026-09-05T19:21:27.000000Z&quot;,
                &quot;perspective&quot;: &quot;neutral&quot;
            }
        ],
        &quot;claims&quot;: []
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-stories--story_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-stories--story_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-stories--story_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-stories--story_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-stories--story_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-stories--story_id-" data-method="GET"
      data-path="api/v1/stories/{story_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-stories--story_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-stories--story_id-"
                    onclick="tryItOut('GETapi-v1-stories--story_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-stories--story_id-"
                    onclick="cancelTryOut('GETapi-v1-stories--story_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-stories--story_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/stories/{story_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-stories--story_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-stories--story_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>story_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="story_id"                data-endpoint="GETapi-v1-stories--story_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the story. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-articles">GET api/v1/articles</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-articles">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/articles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/articles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-articles">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 24
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1339,
            &quot;title&quot;: &quot;OpenAI agent &#039;infiltrated&#039; Australian government website, PM says&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c6vgy0333dppo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Albanese said he expressed \&quot;concern\&quot; to OpenAI founder Sam Altman, after authorities were informed three months after the breach in June.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/f010/live/69f3ee00-b795-11f1-a430-4d16ee157c41.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-24T03:22:54.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1352,
            &quot;title&quot;: &quot;They were labelled &#039;pervert glasses&#039;. Will a camera-free version transform their image?&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cwp80l0my1x2o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Meta has unveiled audio-only smart glasses, with some questioning whether it is a response to the backlash over privacy.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/4bad/live/e6a022b0-b75a-11f1-bc1f-3f186ca4140c.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-24T00:50:24.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1351,
            &quot;title&quot;: &quot;In Amish country, nurses go door to door to stop deadly spread of measles&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/ck3wjyjgj37po?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;With four measles-related deaths in Pennsylvania, health officials are hoping to get people on board with vaccines in private.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/3b31/live/276fdbc0-b768-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-24T00:15:46.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1353,
            &quot;title&quot;: &quot;Residents eating garden weeds in Russian-occupied city cut off from food and water&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c60qxywdx4vvo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The BBC has spoken to residents in the Russian-occupied Ukrainian town of Oleshky who say they are being \&quot;constantly shelled\&quot;.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/3671/live/a0279100-b76a-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T23:58:50.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1354,
            &quot;title&quot;: &quot;&#039;Make women feel seen&#039;: Why the Dutch have a new word for labia&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cn4klprmr0go?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Campaigners hope the new words will lead to less body shaming and more sex positivity.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/3b5f/live/11ea22b0-b736-11f1-aa9c-3d062fa3aea7.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T23:42:38.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1355,
            &quot;title&quot;: &quot;Indians are discovering the thrill of shopping without paying&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cwn741v5rdpxo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Dopamine sites mimic shopping&rsquo;s thrill without the spending, turning the ritual of consumption into a digital game.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/083e/live/e4049770-b732-11f1-9f81-a10976817ca3.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T23:14:10.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1357,
            &quot;title&quot;: &quot;A red carpet and military flyover - How Trump welcomed Xi&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/videos/c6804ne8knklo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The two B-1 bombers that flew overhead are a key part of the US&#039;s combat arsenal, and produce a notoriously loud roar when they pass by.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/92fa/live/b4540960-b7a1-11f1-ba14-197cc9acea52.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T23:03:56.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1340,
            &quot;title&quot;: &quot;AI superpower ambitions take centre stage as Trump and Xi meet&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c6gqdgg8w59xo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The US and China are vying for AI supremacy while seeking to keep it under human control.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/149c/live/60c365b0-b306-11f1-aa6a-fb974fe212f6.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T22:01:17.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1358,
            &quot;title&quot;: &quot;Watch: The arms race in space and how the UK is defending itself&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/videos/c34gdygn5lqpo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The UK has jammed satellites to defend itself from hostile threats, the BBC has been told.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/801a/live/bba851a0-b790-11f1-b1d1-571ed4d7ff2c.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T21:29:04.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1343,
            &quot;title&quot;: &quot;Trump&#039;s Board of Peace unveils $2.45bn plan to begin Gaza&#039;s reconstruction&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cwlyke0mm0x3o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The figure was announced during a meeting of the group&#039;s board at the sidelines of the UN General Assembly in New York. &quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/77bf/live/26f24db0-b770-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T21:26:14.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1345,
            &quot;title&quot;: &quot;UK survivor of Canadian poison seller says he exploited her despair&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cmvgy4237gq9o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Elisabeth Belien tells Kenneth Law&#039;s sentencing hearing she took the poison when she was just 23 years old.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/8549/live/b7449770-b792-11f1-a7dc-51a9fb487fda.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T21:16:00.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1347,
            &quot;title&quot;: &quot;Harvey Weinstein sentenced to 15 years in prison for sexual assault&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cm98626n260yo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Assault survivor Miriam Haley said the \&quot;devastating effect on my life and sense of security that may never go away\&quot;.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/27d6/live/b340ed80-b766-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T18:51:12.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1341,
            &quot;title&quot;: &quot;Iran&#039;s president tells Trump it will never &#039;bend the knee&#039;&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cqvgyjy23ggjo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Masoud Pezeshkian&#039;s defiant speech to the UN comes after the US president threatened to \&quot;annihilate\&quot; Iran if a peace deal is not agreed soon.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/fe3f/live/8c85eb50-b766-11f1-b1d1-571ed4d7ff2c.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T18:15:31.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1342,
            &quot;title&quot;: &quot;Ethiopia and Tigray accuse each of launching offensives, fuelling fears of new war&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cry8zwwq21pxo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The local authorities reportedly seize Tigray&#039;s airports following reports of recent drone strikes.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/9b8d/live/5b472620-b767-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T16:53:37.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1359,
            &quot;title&quot;: &quot;Watch: How toxic smog from wildfires is making Indonesians sick&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/videos/c962j1jgx884o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Around 175,000 people in Indonesia have suffered from respiratory illness since August.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/929e/live/2a02d820-b767-11f1-a7b2-f3bdba1cd194.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T15:46:28.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1348,
            &quot;title&quot;: &quot;Poland accuses Russian military helicopter of violating its airspace&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c699d2dn9z0mo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Poland says the aircraft stayed in its skies for 42 seconds, forcing the Nato member to scramble its fighter jets.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/0465/live/f3c02980-b75b-11f1-8e7f-6f99c81f3136.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T15:37:20.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1350,
            &quot;title&quot;: &quot;Eleven killed in mass shooting at house in South Africa&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/crgjqxzl097eo?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;One of those killed is believed to be a pregnant woman, police said.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/5581/live/0a1fdd60-b716-11f1-8d21-19ad84e0e822.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T14:02:55.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1344,
            &quot;title&quot;: &quot;Dramatic eviction of woman aged 87 highlights Spain&#039;s housing shortage&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c6vgy55lm8z1o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The tenant of the flat in Madrid, Maricarmen, was unable to pay the rent set by the firm which recently bought it.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/3750/live/bcba89f0-b759-11f1-a430-4d16ee157c41.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T12:31:31.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1346,
            &quot;title&quot;: &quot;Dolly Parton&#039;s manager accuses her nephew of &#039;threats and intimidation&#039;&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/c670lydl5wg5o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;Bryan Seaver, who announced Parton&#039;s death to the world, is accused of trying to extort her estate.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/a68a/live/f463e6c0-b75f-11f1-b1d1-571ed4d7ff2c.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T12:22:53.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        },
        {
            &quot;id&quot;: 1360,
            &quot;title&quot;: &quot;Watch: Trump and Xi are meeting on US soil - what&#039;s at stake?&quot;,
            &quot;url&quot;: &quot;https://www.bbc.co.uk/news/videos/c38xk275jd21o?at_medium=RSS&amp;at_campaign=rss&quot;,
            &quot;description&quot;: &quot;The BBC&rsquo;s China correspondent and US editor explain everything you need to know ahead of the Trump-Xi meeting in Washington DC.&quot;,
            &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/0796/live/9166c030-b721-11f1-b1d1-571ed4d7ff2c.jpg&quot;,
            &quot;author&quot;: null,
            &quot;language&quot;: &quot;en&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;published_at&quot;: &quot;2026-09-23T11:00:09.000000Z&quot;,
            &quot;status&quot;: &quot;raw&quot;,
            &quot;importance_score&quot;: 0,
            &quot;ai_summary&quot;: null,
            &quot;source&quot;: {
                &quot;id&quot;: 4,
                &quot;name&quot;: &quot;BBC News&quot;,
                &quot;slug&quot;: &quot;bbc&quot;,
                &quot;bias&quot;: &quot;center-left&quot;
            },
            &quot;category&quot;: {
                &quot;id&quot;: null,
                &quot;name&quot;: null,
                &quot;slug&quot;: null
            }
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 1360,
        &quot;per_page&quot;: 20,
        &quot;current_page&quot;: 1,
        &quot;last_page&quot;: 68
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-articles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-articles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-articles"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-articles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-articles">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-articles" data-method="GET"
      data-path="api/v1/articles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-articles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-articles"
                    onclick="tryItOut('GETapi-v1-articles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-articles"
                    onclick="cancelTryOut('GETapi-v1-articles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-articles"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/articles</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-articles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-articles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-articles-stats-overview">GET api/v1/articles/stats/overview</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-articles-stats-overview">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/articles/stats/overview" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/articles/stats/overview"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-articles-stats-overview">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 23
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;total&quot;: 1360,
        &quot;raw&quot;: 1210,
        &quot;processing&quot;: 0,
        &quot;processed&quot;: 150,
        &quot;failed&quot;: 0,
        &quot;duplicates&quot;: 0,
        &quot;today&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-articles-stats-overview" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-articles-stats-overview"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-articles-stats-overview"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-articles-stats-overview" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-articles-stats-overview">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-articles-stats-overview" data-method="GET"
      data-path="api/v1/articles/stats/overview"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-articles-stats-overview', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-articles-stats-overview"
                    onclick="tryItOut('GETapi-v1-articles-stats-overview');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-articles-stats-overview"
                    onclick="cancelTryOut('GETapi-v1-articles-stats-overview');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-articles-stats-overview"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/articles/stats/overview</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-articles-stats-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-articles-stats-overview"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-articles--article_id-">GET api/v1/articles/{article_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-articles--article_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/articles/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/articles/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-articles--article_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 22
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;title&quot;: &quot;US envoys meet Putin in Moscow for Ukraine talks&quot;,
        &quot;url&quot;: &quot;https://www.bbc.co.uk/news/articles/cx2zqp46g8eo?at_medium=RSS&amp;at_campaign=rss&quot;,
        &quot;description&quot;: &quot;President Trump says his envoys Steve Witkoff and Jared Kushner are \&quot;bringing with them a proposal to end the war\&quot;.&quot;,
        &quot;image_url&quot;: &quot;https://ichef.bbci.co.uk/ace/standard/240/cpsprodpb/5833/live/8e0ff630-a94e-11f1-ae8c-2528accc9a1a.jpg&quot;,
        &quot;author&quot;: null,
        &quot;language&quot;: &quot;en&quot;,
        &quot;country_code&quot;: &quot;GB&quot;,
        &quot;published_at&quot;: &quot;2026-09-05T17:18:31.000000Z&quot;,
        &quot;status&quot;: &quot;processed&quot;,
        &quot;importance_score&quot;: 50,
        &quot;ai_summary&quot;: &quot;US President Trump&#039;s envoys Steve Witkoff and Jared Kushner met with Russian President Putin in Moscow to discuss a proposal to end the war in Ukraine.&quot;,
        &quot;source&quot;: {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;BBC News&quot;,
            &quot;slug&quot;: &quot;bbc&quot;,
            &quot;bias&quot;: &quot;center-left&quot;
        },
        &quot;category&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Politics&quot;,
            &quot;slug&quot;: &quot;politics&quot;
        },
        &quot;ai_categories&quot;: [
            &quot;politics&quot;
        ],
        &quot;is_duplicate&quot;: false,
        &quot;duplicate_of&quot;: null,
        &quot;stories&quot;: [
            &quot;us-envoys-meet-putin-in-moscow-for-ukraine-talks&quot;
        ],
        &quot;entities&quot;: []
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-articles--article_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-articles--article_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-articles--article_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-articles--article_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-articles--article_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-articles--article_id-" data-method="GET"
      data-path="api/v1/articles/{article_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-articles--article_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-articles--article_id-"
                    onclick="tryItOut('GETapi-v1-articles--article_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-articles--article_id-"
                    onclick="cancelTryOut('GETapi-v1-articles--article_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-articles--article_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/articles/{article_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-articles--article_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-articles--article_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>article_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="article_id"                data-endpoint="GETapi-v1-articles--article_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the article. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-briefings">GET api/v1/briefings</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-briefings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/briefings" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/briefings"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-briefings">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 21
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 4,
            &quot;type&quot;: &quot;daily&quot;,
            &quot;title&quot;: &quot;Daily News Briefing&quot;,
            &quot;period_start&quot;: &quot;2026-09-18&quot;,
            &quot;period_end&quot;: &quot;2026-09-18&quot;,
            &quot;stories_count&quot;: 10,
            &quot;published_at&quot;: &quot;2026-09-19T13:43:52.000000Z&quot;
        },
        {
            &quot;id&quot;: 3,
            &quot;type&quot;: &quot;monthly&quot;,
            &quot;title&quot;: &quot;Monthly News Review Briefing&quot;,
            &quot;period_start&quot;: &quot;2026-08-01&quot;,
            &quot;period_end&quot;: &quot;2026-08-31&quot;,
            &quot;stories_count&quot;: 10,
            &quot;published_at&quot;: &quot;2026-09-08T12:26:09.000000Z&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;type&quot;: &quot;weekly&quot;,
            &quot;title&quot;: &quot;Weekly Briefing &mdash; Week of Sep 08, 2026&quot;,
            &quot;period_start&quot;: &quot;2026-08-31&quot;,
            &quot;period_end&quot;: &quot;2026-09-06&quot;,
            &quot;stories_count&quot;: 20,
            &quot;published_at&quot;: &quot;2026-09-08T12:24:35.000000Z&quot;
        },
        {
            &quot;id&quot;: 1,
            &quot;type&quot;: &quot;daily&quot;,
            &quot;title&quot;: &quot;Global News Briefing&quot;,
            &quot;period_start&quot;: &quot;2026-09-05&quot;,
            &quot;period_end&quot;: &quot;2026-09-05&quot;,
            &quot;stories_count&quot;: 10,
            &quot;published_at&quot;: &quot;2026-09-06T14:22:08.000000Z&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 4,
        &quot;current_page&quot;: 1,
        &quot;last_page&quot;: 1
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-briefings" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-briefings"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-briefings"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-briefings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-briefings">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-briefings" data-method="GET"
      data-path="api/v1/briefings"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-briefings', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-briefings"
                    onclick="tryItOut('GETapi-v1-briefings');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-briefings"
                    onclick="cancelTryOut('GETapi-v1-briefings');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-briefings"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/briefings</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-briefings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-briefings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-briefings-latest--type-">GET api/v1/briefings/latest/{type}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-briefings-latest--type-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/briefings/latest/consequatur" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/briefings/latest/consequatur"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-briefings-latest--type-">
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 20
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Invalid briefing type.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-briefings-latest--type-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-briefings-latest--type-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-briefings-latest--type-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-briefings-latest--type-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-briefings-latest--type-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-briefings-latest--type-" data-method="GET"
      data-path="api/v1/briefings/latest/{type}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-briefings-latest--type-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-briefings-latest--type-"
                    onclick="tryItOut('GETapi-v1-briefings-latest--type-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-briefings-latest--type-"
                    onclick="cancelTryOut('GETapi-v1-briefings-latest--type-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-briefings-latest--type-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/briefings/latest/{type}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-briefings-latest--type-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-briefings-latest--type-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-v1-briefings-latest--type-"
               value="consequatur"
               data-component="url">
    <br>
<p>Example: <code>consequatur</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-briefings--briefing_id-">GET api/v1/briefings/{briefing_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-briefings--briefing_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/briefings/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/briefings/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-briefings--briefing_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 19
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;type&quot;: &quot;daily&quot;,
        &quot;title&quot;: &quot;Global News Briefing&quot;,
        &quot;introduction&quot;: &quot;Good morning, this is your daily news briefing. We bring you the latest updates on global events, politics, and sports. Our team of experts has curated the top stories for you today.&quot;,
        &quot;sections&quot;: &quot;Our briefing covers the latest news on politics, sports, and global events.&quot;,
        &quot;conclusion&quot;: &quot;That&#039;s all for today&#039;s news briefing. We&#039;ll be back with more updates tomorrow.&quot;,
        &quot;top_stories&quot;: &quot;Today&#039;s top stories include a dramatic match in Serie A, ongoing investigations into US military leaks, and tensions between migrants and authorities in Dover. Additionally, high-level talks between Russia and Ukraine are underway.&quot;,
        &quot;key_developments&quot;: &quot;Key developments include the ongoing investigation into US military leaks, with the Pentagon submitting military officers to polygraph tests. In another development, tensions between migrants and authorities in Dover are escalating. Meanwhile, high-level talks between Russia and Ukraine are underway.&quot;,
        &quot;period_start&quot;: &quot;2026-09-05&quot;,
        &quot;period_end&quot;: &quot;2026-09-05&quot;,
        &quot;stories_count&quot;: 10,
        &quot;articles_count&quot;: 10,
        &quot;sources_count&quot;: 10,
        &quot;languages_available&quot;: [
            &quot;en&quot;,
            &quot;ar&quot;
        ],
        &quot;published_at&quot;: &quot;2026-09-06T14:22:08.000000Z&quot;,
        &quot;stories&quot;: [
            {
                &quot;slug&quot;: &quot;serie-a-in-campo-inter-napoli-1-2-diretta&quot;,
                &quot;title&quot;: &quot;Serie A: in campo Inter-Napoli 1-2 DIRETTA&quot;,
                &quot;section&quot;: &quot;sports&quot;,
                &quot;order&quot;: 1,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Ospiti avanti con Politano e Hojlund\&quot;,\&quot;ar\&quot;:\&quot;Ospiti avanti con Politano e Hojlund\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;us-pentagon-submits-military-officers-to-polygraph-tests-amid-leaks-investigation&quot;,
                &quot;title&quot;: &quot;US Pentagon Submits Military Officers to Polygraph Tests Amid Leaks Investigation&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 2,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Une cinquantaine de membres de l\\u2019\\u00e9tat-major ont \\u00e9t\\u00e9 interrog\\u00e9s au polygraphe pour identifier la source d\\u2019une fuite sur une possible p\\u00e9nurie de munitions am\\u00e9ricaines.\&quot;,\&quot;ar\&quot;:\&quot;Une cinquantaine de membres de l\\u2019\\u00e9tat-major ont \\u00e9t\\u00e9 interrog\\u00e9s au polygraphe pour identifier la source d\\u2019une fuite sur une possible p\\u00e9nurie de munitions am\\u00e9ricaines.\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;incappucciati-invadono-dover-contro-i-migranti&quot;,
                &quot;title&quot;: &quot;Incappucciati invadono Dover contro i migranti&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 3,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot; Farage &#039;fermeremo le barche&#039;. Il leader di Reform tenta il rilancio: &#039;Se non vinciamo le elezioni sar\\u00e0 irreversibile il declino inglese&#039; \&quot;,\&quot;ar\&quot;:\&quot; Farage &#039;fermeremo le barche&#039;. Il leader di Reform tenta il rilancio: &#039;Se non vinciamo le elezioni sar\\u00e0 irreversibile il declino inglese&#039; \&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;ucraina-in-corso-lincontro-di-putin-con-witkoff-e-kushner&quot;,
                &quot;title&quot;: &quot;Ucraina, in corso l&#039;incontro di Putin con Witkoff e Kushner&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 4,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Gi inviati americani Steve Witkoff e Jared Kushner in Russia\&quot;,\&quot;ar\&quot;:\&quot;Gi inviati americani Steve Witkoff e Jared Kushner in Russia\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;russia-ukraine-talks-poutine-meets-with-us-envoy-team&quot;,
                &quot;title&quot;: &quot;Russia-Ukraine Talks: Poutine Meets with US Envoy Team&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 5,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Donald Trump n\\u2019a pas pr\\u00e9cis\\u00e9 si la proposition dont ses \\u00e9missaires sont porteurs impliquait une cession de territoire de la part de l\\u2019Ukraine, comme il l\\u2019avait laiss\\u00e9 entendre auparavant. Les deux hommes doivent rencontrer dimanche Volodymyr Zelensky, \\u00e0 Kiev, pour la premi\\u00e8re fois depuis le d\\u00e9but de leur travail de m\\u00e9diateur.\&quot;,\&quot;ar\&quot;:\&quot;Donald Trump n\\u2019a pas pr\\u00e9cis\\u00e9 si la proposition dont ses \\u00e9missaires sont porteurs impliquait une cession de territoire de la part de l\\u2019Ukraine, comme il l\\u2019avait laiss\\u00e9 entendre auparavant. Les deux hommes doivent rencontrer dimanche Volodymyr Zelensky, \\u00e0 Kiev, pour la premi\\u00e8re fois depuis le d\\u00e9but de leur travail de m\\u00e9diateur.\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;usa-colpiscono-tre-petroliere-iraniane-missile-vicino-kharg&quot;,
                &quot;title&quot;: &quot;Usa colpiscono tre petroliere iraniane, missile vicino Kharg&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 6,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Ritorsione per razzi su navi. Tycoon: &#039;Solo Attacchi, briciole&#039;. Piano per il dopo guerra \&quot;,\&quot;ar\&quot;:\&quot;Ritorsione per razzi su navi. Tycoon: &#039;Solo Attacchi, briciole&#039;. Piano per il dopo guerra \&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;la-procura-di-roma-indaga-sugli-italiani-negli-epstein-file&quot;,
                &quot;title&quot;: &quot;La procura di Roma indaga sugli italiani negli Epstein file&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 7,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Fascicolo contro ignoti, rogatoria su atti riservati. Differenza Donna: &#039;passo importante&#039; \&quot;,\&quot;ar\&quot;:\&quot;Fascicolo contro ignoti, rogatoria su atti riservati. Differenza Donna: &#039;passo importante&#039; \&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;famiglia-nel-bosco-la-decisione-ci-spezza-il-cuore-faremo-ricorso&quot;,
                &quot;title&quot;: &quot;Famiglia nel bosco: &#039;La decisione ci spezza il cuore, faremo ricorso&#039;&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 8,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Video dei genitori dopo la decisione del tribunale. Pillon: &#039;inerzia dei servizi sociali&#039;\&quot;,\&quot;ar\&quot;:\&quot;Video dei genitori dopo la decisione del tribunale. Pillon: &#039;inerzia dei servizi sociali&#039;\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;incidente-al-rally-1000-miglia-spettatore-muore-investito&quot;,
                &quot;title&quot;: &quot;Incidente al Rally 1000 Miglia, spettatore muore investito&quot;,
                &quot;section&quot;: &quot;politics&quot;,
                &quot;order&quot;: 9,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Vittima un 63enne di Torino, la direzione di gara ha sospeso la manifestazione\&quot;,\&quot;ar\&quot;:\&quot;Vittima un 63enne di Torino, la direzione di gara ha sospeso la manifestazione\&quot;}&quot;
            },
            {
                &quot;slug&quot;: &quot;hamilton-takes-fourth-at-monza-despite-controversy&quot;,
                &quot;title&quot;: &quot;English&quot;,
                &quot;section&quot;: &quot;sports&quot;,
                &quot;order&quot;: 10,
                &quot;summary&quot;: &quot;{\&quot;en\&quot;:\&quot;Charles Leclerc secured third place despite a penalty for his teammate, Daniel Ricciardo, while Pierre Gasly took pole position at the Italian Grand Prix. Meanwhile, Lewis Hamilton finished fourth, amidst controversy surrounding the penalty given to Ricciardo.\&quot;,\&quot;ar\&quot;:\&quot;\&quot;}&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-briefings--briefing_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-briefings--briefing_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-briefings--briefing_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-briefings--briefing_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-briefings--briefing_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-briefings--briefing_id-" data-method="GET"
      data-path="api/v1/briefings/{briefing_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-briefings--briefing_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-briefings--briefing_id-"
                    onclick="tryItOut('GETapi-v1-briefings--briefing_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-briefings--briefing_id-"
                    onclick="cancelTryOut('GETapi-v1-briefings--briefing_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-briefings--briefing_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/briefings/{briefing_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-briefings--briefing_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-briefings--briefing_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>briefing_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="briefing_id"                data-endpoint="GETapi-v1-briefings--briefing_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the briefing. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-v1-dashboard">GET api/v1/dashboard</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-dashboard">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/dashboard" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/dashboard"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-dashboard">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 18
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;articles&quot;: {
            &quot;total&quot;: 1360,
            &quot;today&quot;: 0,
            &quot;raw&quot;: 1210,
            &quot;processed&quot;: 150,
            &quot;duplicates&quot;: 0
        },
        &quot;sources&quot;: {
            &quot;total&quot;: 36,
            &quot;active&quot;: 33
        },
        &quot;stories&quot;: {
            &quot;total&quot;: 147,
            &quot;published&quot;: 147,
            &quot;trending&quot;: 3
        },
        &quot;categories&quot;: 10,
        &quot;briefings&quot;: 4,
        &quot;ai&quot;: {
            &quot;available_providers&quot;: []
        },
        &quot;languages&quot;: {
            &quot;ar&quot;: 348,
            &quot;en&quot;: 535,
            &quot;es&quot;: 170,
            &quot;fr&quot;: 165,
            &quot;it&quot;: 142
        }
    },
    &quot;meta&quot;: {
        &quot;cached&quot;: true,
        &quot;ttl_seconds&quot;: 300
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-dashboard" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-dashboard"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-dashboard"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-dashboard" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-dashboard">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-dashboard" data-method="GET"
      data-path="api/v1/dashboard"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-dashboard', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-dashboard"
                    onclick="tryItOut('GETapi-v1-dashboard');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-dashboard"
                    onclick="cancelTryOut('GETapi-v1-dashboard');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-dashboard"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/dashboard</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-dashboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-dashboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-sources">GET api/v1/sources</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-sources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/sources" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/sources"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-sources">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 17
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Reuters&quot;,
            &quot;slug&quot;: &quot;reuters&quot;,
            &quot;website_url&quot;: &quot;https://www.reuters.com&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;wire_agency&quot;,
            &quot;reliability_score&quot;: 90,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: false,
            &quot;fetch_interval_minutes&quot;: 15,
            &quot;last_fetched_at&quot;: &quot;2026-09-05T17:30:33.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;Associated Press&quot;,
            &quot;slug&quot;: &quot;ap&quot;,
            &quot;website_url&quot;: &quot;https://apnews.com&quot;,
            &quot;country_code&quot;: &quot;US&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;wire_agency&quot;,
            &quot;reliability_score&quot;: 90,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: false,
            &quot;fetch_interval_minutes&quot;: 15,
            &quot;last_fetched_at&quot;: &quot;2026-09-05T17:30:34.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 3,
            &quot;name&quot;: &quot;Agence France-Presse&quot;,
            &quot;slug&quot;: &quot;afp&quot;,
            &quot;website_url&quot;: &quot;https://www.afp.com&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;wire_agency&quot;,
            &quot;reliability_score&quot;: 88,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: false,
            &quot;fetch_interval_minutes&quot;: 15,
            &quot;last_fetched_at&quot;: null,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 4,
            &quot;name&quot;: &quot;BBC News&quot;,
            &quot;slug&quot;: &quot;bbc&quot;,
            &quot;website_url&quot;: &quot;https://www.bbc.com/news&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 85,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-24T03:55:53.000000Z&quot;,
            &quot;articles_count&quot;: 116
        },
        {
            &quot;id&quot;: 5,
            &quot;name&quot;: &quot;Al Jazeera English&quot;,
            &quot;slug&quot;: &quot;aljazeera-en&quot;,
            &quot;website_url&quot;: &quot;https://www.aljazeera.com&quot;,
            &quot;country_code&quot;: &quot;QA&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 78,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:24.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 6,
            &quot;name&quot;: &quot;DW News&quot;,
            &quot;slug&quot;: &quot;dw&quot;,
            &quot;website_url&quot;: &quot;https://www.dw.com/en&quot;,
            &quot;country_code&quot;: &quot;DE&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 82,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:27.000000Z&quot;,
            &quot;articles_count&quot;: 115
        },
        {
            &quot;id&quot;: 7,
            &quot;name&quot;: &quot;France 24 English&quot;,
            &quot;slug&quot;: &quot;france24-en&quot;,
            &quot;website_url&quot;: &quot;https://www.france24.com/en&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 80,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:29.000000Z&quot;,
            &quot;articles_count&quot;: 62
        },
        {
            &quot;id&quot;: 8,
            &quot;name&quot;: &quot;RT News&quot;,
            &quot;slug&quot;: &quot;rt&quot;,
            &quot;website_url&quot;: &quot;https://www.rt.com&quot;,
            &quot;country_code&quot;: &quot;RU&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;state&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 45,
            &quot;reliability_label&quot;: &quot;low&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:34.000000Z&quot;,
            &quot;articles_count&quot;: 113
        },
        {
            &quot;id&quot;: 9,
            &quot;name&quot;: &quot;الجزيرة&quot;,
            &quot;slug&quot;: &quot;aljazeera-ar&quot;,
            &quot;website_url&quot;: &quot;https://www.aljazeera.net&quot;,
            &quot;country_code&quot;: &quot;QA&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 78,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:44.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 10,
            &quot;name&quot;: &quot;العربية&quot;,
            &quot;slug&quot;: &quot;alarabiya&quot;,
            &quot;website_url&quot;: &quot;https://www.alarabiya.net&quot;,
            &quot;country_code&quot;: &quot;SA&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-right&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 72,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:45.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 11,
            &quot;name&quot;: &quot;فرانس 24 عربي&quot;,
            &quot;slug&quot;: &quot;france24-ar&quot;,
            &quot;website_url&quot;: &quot;https://www.france24.com/ar&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 80,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-19T12:35:18.000000Z&quot;,
            &quot;articles_count&quot;: 78
        },
        {
            &quot;id&quot;: 12,
            &quot;name&quot;: &quot;BBC عربي&quot;,
            &quot;slug&quot;: &quot;bbc-ar&quot;,
            &quot;website_url&quot;: &quot;https://www.bbc.com/arabic&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 85,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-19T12:35:17.000000Z&quot;,
            &quot;articles_count&quot;: 70
        },
        {
            &quot;id&quot;: 13,
            &quot;name&quot;: &quot;Le Monde&quot;,
            &quot;slug&quot;: &quot;lemonde&quot;,
            &quot;website_url&quot;: &quot;https://www.lemonde.fr&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;newspaper&quot;,
            &quot;reliability_score&quot;: 85,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:49.000000Z&quot;,
            &quot;articles_count&quot;: 48
        },
        {
            &quot;id&quot;: 14,
            &quot;name&quot;: &quot;France 24 Fran&ccedil;ais&quot;,
            &quot;slug&quot;: &quot;france24-fr&quot;,
            &quot;website_url&quot;: &quot;https://www.france24.com/fr&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 80,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:50.000000Z&quot;,
            &quot;articles_count&quot;: 71
        },
        {
            &quot;id&quot;: 15,
            &quot;name&quot;: &quot;El Pa&iacute;s&quot;,
            &quot;slug&quot;: &quot;elpais&quot;,
            &quot;website_url&quot;: &quot;https://elpais.com&quot;,
            &quot;country_code&quot;: &quot;ES&quot;,
            &quot;language&quot;: &quot;es&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;newspaper&quot;,
            &quot;reliability_score&quot;: 83,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:52.000000Z&quot;,
            &quot;articles_count&quot;: 150
        },
        {
            &quot;id&quot;: 16,
            &quot;name&quot;: &quot;ANSA&quot;,
            &quot;slug&quot;: &quot;ansa&quot;,
            &quot;website_url&quot;: &quot;https://www.ansa.it&quot;,
            &quot;country_code&quot;: &quot;IT&quot;,
            &quot;language&quot;: &quot;it&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;wire_agency&quot;,
            &quot;reliability_score&quot;: 82,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:54.000000Z&quot;,
            &quot;articles_count&quot;: 82
        },
        {
            &quot;id&quot;: 17,
            &quot;name&quot;: &quot;مصراوي&quot;,
            &quot;slug&quot;: &quot;masrawy&quot;,
            &quot;website_url&quot;: &quot;https://www.masrawy.com&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 70,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:55.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 18,
            &quot;name&quot;: &quot;اليوم السابع&quot;,
            &quot;slug&quot;: &quot;youm7&quot;,
            &quot;website_url&quot;: &quot;https://www.youm7.com&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 68,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:56.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 19,
            &quot;name&quot;: &quot;الأهرام&quot;,
            &quot;slug&quot;: &quot;ahram&quot;,
            &quot;website_url&quot;: &quot;https://gate.ahram.org.eg&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;newspaper&quot;,
            &quot;reliability_score&quot;: 72,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:15:57.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 20,
            &quot;name&quot;: &quot;Egypt Independent&quot;,
            &quot;slug&quot;: &quot;egypt-independent&quot;,
            &quot;website_url&quot;: &quot;https://egyptindependent.com&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 71,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:01.000000Z&quot;,
            &quot;articles_count&quot;: 20
        },
        {
            &quot;id&quot;: 21,
            &quot;name&quot;: &quot;المواطن سعيد&quot;,
            &quot;slug&quot;: &quot;almoatn-said&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@almoatnsaid&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 60,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 60,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:02.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 22,
            &quot;name&quot;: &quot;قناة سامري&quot;,
            &quot;slug&quot;: &quot;samri&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@samri&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 62,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 60,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:03.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 23,
            &quot;name&quot;: &quot;مصطفى الأزهري&quot;,
            &quot;slug&quot;: &quot;alazhari&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@MostafaAlazhari&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 63,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 60,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:04.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 24,
            &quot;name&quot;: &quot;DW عربية&quot;,
            &quot;slug&quot;: &quot;dw-ar&quot;,
            &quot;website_url&quot;: &quot;https://www.dw.com/ar&quot;,
            &quot;country_code&quot;: &quot;DE&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 82,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-19T12:35:25.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 25,
            &quot;name&quot;: &quot;Al Jazeera English YT&quot;,
            &quot;slug&quot;: &quot;aljazeera-yt&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@AlJazeeraEnglish&quot;,
            &quot;country_code&quot;: &quot;QA&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 78,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:06.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 26,
            &quot;name&quot;: &quot;The Guardian&quot;,
            &quot;slug&quot;: &quot;guardian&quot;,
            &quot;website_url&quot;: &quot;https://www.theguardian.com&quot;,
            &quot;country_code&quot;: &quot;GB&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;newspaper&quot;,
            &quot;reliability_score&quot;: 83,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:09.000000Z&quot;,
            &quot;articles_count&quot;: 89
        },
        {
            &quot;id&quot;: 27,
            &quot;name&quot;: &quot;NPR News&quot;,
            &quot;slug&quot;: &quot;npr&quot;,
            &quot;website_url&quot;: &quot;https://www.npr.org&quot;,
            &quot;country_code&quot;: &quot;US&quot;,
            &quot;language&quot;: &quot;en&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 82,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:10.000000Z&quot;,
            &quot;articles_count&quot;: 20
        },
        {
            &quot;id&quot;: 28,
            &quot;name&quot;: &quot;روسيا اليوم عربي&quot;,
            &quot;slug&quot;: &quot;rt-ar&quot;,
            &quot;website_url&quot;: &quot;https://arabic.rt.com&quot;,
            &quot;country_code&quot;: &quot;RU&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;state&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 45,
            &quot;reliability_label&quot;: &quot;low&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-19T12:35:21.000000Z&quot;,
            &quot;articles_count&quot;: 150
        },
        {
            &quot;id&quot;: 29,
            &quot;name&quot;: &quot;سكاي نيوز عربية&quot;,
            &quot;slug&quot;: &quot;skynews-ar&quot;,
            &quot;website_url&quot;: &quot;https://www.skynewsarabia.com&quot;,
            &quot;country_code&quot;: &quot;AE&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-right&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 72,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:15.000000Z&quot;,
            &quot;articles_count&quot;: 50
        },
        {
            &quot;id&quot;: 30,
            &quot;name&quot;: &quot;RFI Fran&ccedil;ais&quot;,
            &quot;slug&quot;: &quot;rfi-fr&quot;,
            &quot;website_url&quot;: &quot;https://www.rfi.fr&quot;,
            &quot;country_code&quot;: &quot;FR&quot;,
            &quot;language&quot;: &quot;fr&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 80,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 20,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:16.000000Z&quot;,
            &quot;articles_count&quot;: 46
        },
        {
            &quot;id&quot;: 31,
            &quot;name&quot;: &quot;RT Espa&ntilde;ol&quot;,
            &quot;slug&quot;: &quot;rt-es&quot;,
            &quot;website_url&quot;: &quot;https://actualidad.rt.com&quot;,
            &quot;country_code&quot;: &quot;RU&quot;,
            &quot;language&quot;: &quot;es&quot;,
            &quot;bias&quot;: &quot;state&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 45,
            &quot;reliability_label&quot;: &quot;low&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:19.000000Z&quot;,
            &quot;articles_count&quot;: 20
        },
        {
            &quot;id&quot;: 32,
            &quot;name&quot;: &quot;La Repubblica&quot;,
            &quot;slug&quot;: &quot;repubblica&quot;,
            &quot;website_url&quot;: &quot;https://www.repubblica.it&quot;,
            &quot;country_code&quot;: &quot;IT&quot;,
            &quot;language&quot;: &quot;it&quot;,
            &quot;bias&quot;: &quot;center-left&quot;,
            &quot;type&quot;: &quot;newspaper&quot;,
            &quot;reliability_score&quot;: 80,
            &quot;reliability_label&quot;: &quot;high&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:21.000000Z&quot;,
            &quot;articles_count&quot;: 60
        },
        {
            &quot;id&quot;: 33,
            &quot;name&quot;: &quot;Summary - سمري&quot;,
            &quot;slug&quot;: &quot;summary-yt&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@SummaryAR&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 65,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 60,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:22.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 34,
            &quot;name&quot;: &quot;المواطن سعيد&quot;,
            &quot;slug&quot;: &quot;almoatn-said-yt&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@almoatnsaid&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;digital&quot;,
            &quot;reliability_score&quot;: 63,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 60,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:23.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 35,
            &quot;name&quot;: &quot;القاهرة الإخبارية&quot;,
            &quot;slug&quot;: &quot;alqahera-news-yt&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@AlQaheraNews&quot;,
            &quot;country_code&quot;: &quot;EG&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 68,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:23.000000Z&quot;,
            &quot;articles_count&quot;: 0
        },
        {
            &quot;id&quot;: 36,
            &quot;name&quot;: &quot;سكاي نيوز عربية&quot;,
            &quot;slug&quot;: &quot;skynews-ar-yt&quot;,
            &quot;website_url&quot;: &quot;https://www.youtube.com/@skynewsarabia&quot;,
            &quot;country_code&quot;: &quot;AE&quot;,
            &quot;language&quot;: &quot;ar&quot;,
            &quot;bias&quot;: &quot;center-right&quot;,
            &quot;type&quot;: &quot;tv_channel&quot;,
            &quot;reliability_score&quot;: 72,
            &quot;reliability_label&quot;: &quot;medium&quot;,
            &quot;is_active&quot;: true,
            &quot;fetch_interval_minutes&quot;: 30,
            &quot;last_fetched_at&quot;: &quot;2026-09-14T14:16:24.000000Z&quot;,
            &quot;articles_count&quot;: 0
        }
    ],
    &quot;meta&quot;: {
        &quot;total&quot;: 36
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-sources" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-sources"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-sources"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-sources" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-sources">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-sources" data-method="GET"
      data-path="api/v1/sources"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-sources', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-sources"
                    onclick="tryItOut('GETapi-v1-sources');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-sources"
                    onclick="cancelTryOut('GETapi-v1-sources');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-sources"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/sources</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-sources--source_id-">GET api/v1/sources/{source_id}</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-sources--source_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/sources/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/sources/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-sources--source_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 30
x-ratelimit-remaining: 16
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;ok&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;name&quot;: &quot;Reuters&quot;,
        &quot;slug&quot;: &quot;reuters&quot;,
        &quot;website_url&quot;: &quot;https://www.reuters.com&quot;,
        &quot;feed_url&quot;: &quot;https://feeds.reuters.com/reuters/topNews&quot;,
        &quot;country_code&quot;: &quot;GB&quot;,
        &quot;language&quot;: &quot;en&quot;,
        &quot;bias&quot;: &quot;center&quot;,
        &quot;type&quot;: &quot;wire_agency&quot;,
        &quot;reliability_score&quot;: 90,
        &quot;reliability_label&quot;: &quot;high&quot;,
        &quot;is_active&quot;: false,
        &quot;fetch_interval_minutes&quot;: 15,
        &quot;last_fetched_at&quot;: &quot;2026-09-05T17:30:33.000000Z&quot;,
        &quot;articles_count&quot;: 0,
        &quot;is_due_for_fetch&quot;: true
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-sources--source_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-sources--source_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-sources--source_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-sources--source_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-sources--source_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-sources--source_id-" data-method="GET"
      data-path="api/v1/sources/{source_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-sources--source_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-sources--source_id-"
                    onclick="tryItOut('GETapi-v1-sources--source_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-sources--source_id-"
                    onclick="cancelTryOut('GETapi-v1-sources--source_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-sources--source_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/sources/{source_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-sources--source_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-sources--source_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="GETapi-v1-sources--source_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the source. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-auth-logout">POST api/v1/auth/logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-auth-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8080/api/v1/auth/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/auth/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-logout">
</span>
<span id="execution-results-POSTapi-v1-auth-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-logout" data-method="POST"
      data-path="api/v1/auth/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-logout"
                    onclick="tryItOut('POSTapi-v1-auth-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-logout"
                    onclick="cancelTryOut('POSTapi-v1-auth-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-auth-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-v1-auth-me">GET api/v1/auth/me</h2>

<p>
</p>



<span id="example-requests-GETapi-v1-auth-me">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/auth/me" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/auth/me"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-me">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Unauthenticated. Please provide a valid Bearer token.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-me" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-me"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-me"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-me" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-me">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-me" data-method="GET"
      data-path="api/v1/auth/me"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-me', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-me"
                    onclick="tryItOut('GETapi-v1-auth-me');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-me"
                    onclick="cancelTryOut('GETapi-v1-auth-me');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-me"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/me</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-auth-me"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-PUTapi-v1-auth-password">PUT api/v1/auth/password</h2>

<p>
</p>



<span id="example-requests-PUTapi-v1-auth-password">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost:8080/api/v1/auth/password" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"current_password\": \"consequatur\",
    \"password\": \"[2UZ5ij-e\\/dl4\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/auth/password"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "current_password": "consequatur",
    "password": "[2UZ5ij-e\/dl4"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-auth-password">
</span>
<span id="execution-results-PUTapi-v1-auth-password" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-auth-password"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-auth-password"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-auth-password" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-auth-password">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-auth-password" data-method="PUT"
      data-path="api/v1/auth/password"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-auth-password', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-auth-password"
                    onclick="tryItOut('PUTapi-v1-auth-password');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-auth-password"
                    onclick="cancelTryOut('PUTapi-v1-auth-password');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-auth-password"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/auth/password</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-auth-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-auth-password"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>current_password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="current_password"                data-endpoint="PUTapi-v1-auth-password"
               value="consequatur"
               data-component="body">
    <br>
<p>Example: <code>consequatur</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="PUTapi-v1-auth-password"
               value="[2UZ5ij-e/dl4"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>[2UZ5ij-e/dl4</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-v1-preferences-sources">Return all sources with the authenticated user&#039;s preference for each.</h2>

<p>
</p>

<p>Sources with no preference record default to enabled.</p>

<span id="example-requests-GETapi-v1-preferences-sources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8080/api/v1/preferences/sources" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/preferences/sources"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-preferences-sources">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: http://localhost:8080
access-control-expose-headers: X-RateLimit-Limit, X-RateLimit-Remaining, Retry-After
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;status&quot;: &quot;error&quot;,
    &quot;message&quot;: &quot;Unauthenticated. Please provide a valid Bearer token.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-preferences-sources" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-preferences-sources"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-preferences-sources"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-preferences-sources" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-preferences-sources">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-preferences-sources" data-method="GET"
      data-path="api/v1/preferences/sources"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-preferences-sources', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-preferences-sources"
                    onclick="tryItOut('GETapi-v1-preferences-sources');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-preferences-sources"
                    onclick="cancelTryOut('GETapi-v1-preferences-sources');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-preferences-sources"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/preferences/sources</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-PUTapi-v1-preferences-sources--source_id-">Toggle a single source on or off.</h2>

<p>
</p>



<span id="example-requests-PUTapi-v1-preferences-sources--source_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost:8080/api/v1/preferences/sources/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"is_enabled\": false
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/preferences/sources/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "is_enabled": false
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-preferences-sources--source_id-">
</span>
<span id="execution-results-PUTapi-v1-preferences-sources--source_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-preferences-sources--source_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-preferences-sources--source_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-preferences-sources--source_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-preferences-sources--source_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-preferences-sources--source_id-" data-method="PUT"
      data-path="api/v1/preferences/sources/{source_id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-preferences-sources--source_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-preferences-sources--source_id-"
                    onclick="tryItOut('PUTapi-v1-preferences-sources--source_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-preferences-sources--source_id-"
                    onclick="cancelTryOut('PUTapi-v1-preferences-sources--source_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-preferences-sources--source_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/preferences/sources/{source_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-preferences-sources--source_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-preferences-sources--source_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="PUTapi-v1-preferences-sources--source_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the source. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>is_enabled</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-preferences-sources--source_id-" style="display: none">
            <input type="radio" name="is_enabled"
                   value="true"
                   data-endpoint="PUTapi-v1-preferences-sources--source_id-"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-preferences-sources--source_id-" style="display: none">
            <input type="radio" name="is_enabled"
                   value="false"
                   data-endpoint="PUTapi-v1-preferences-sources--source_id-"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-v1-preferences-sources">Bulk update all source preferences at once.</h2>

<p>
</p>



<span id="example-requests-PUTapi-v1-preferences-sources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost:8080/api/v1/preferences/sources" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"sources\": [
        {
            \"id\": 17,
            \"enabled\": false
        }
    ]
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/preferences/sources"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "sources": [
        {
            "id": 17,
            "enabled": false
        }
    ]
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-preferences-sources">
</span>
<span id="execution-results-PUTapi-v1-preferences-sources" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-preferences-sources"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-preferences-sources"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-preferences-sources" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-preferences-sources">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-preferences-sources" data-method="PUT"
      data-path="api/v1/preferences/sources"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-preferences-sources', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-preferences-sources"
                    onclick="tryItOut('PUTapi-v1-preferences-sources');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-preferences-sources"
                    onclick="cancelTryOut('PUTapi-v1-preferences-sources');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-preferences-sources"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/preferences/sources</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>sources</code></b>&nbsp;&nbsp;
<small>object[]</small>&nbsp;
 &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="sources.0.id"                data-endpoint="PUTapi-v1-preferences-sources"
               value="17"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>17</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>enabled</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
 &nbsp;
 &nbsp;
                <label data-endpoint="PUTapi-v1-preferences-sources" style="display: none">
            <input type="radio" name="sources.0.enabled"
                   value="true"
                   data-endpoint="PUTapi-v1-preferences-sources"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="PUTapi-v1-preferences-sources" style="display: none">
            <input type="radio" name="sources.0.enabled"
                   value="false"
                   data-endpoint="PUTapi-v1-preferences-sources"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>false</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-v1-preferences-sources">Reset all preferences to enabled (default state).</h2>

<p>
</p>



<span id="example-requests-DELETEapi-v1-preferences-sources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost:8080/api/v1/preferences/sources" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/preferences/sources"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-preferences-sources">
</span>
<span id="execution-results-DELETEapi-v1-preferences-sources" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-preferences-sources"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-preferences-sources"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-preferences-sources" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-preferences-sources">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-preferences-sources" data-method="DELETE"
      data-path="api/v1/preferences/sources"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-preferences-sources', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-preferences-sources"
                    onclick="tryItOut('DELETEapi-v1-preferences-sources');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-preferences-sources"
                    onclick="cancelTryOut('DELETEapi-v1-preferences-sources');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-preferences-sources"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/preferences/sources</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-preferences-sources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-v1-sources--source_id--fetch">POST api/v1/sources/{source_id}/fetch</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-sources--source_id--fetch">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8080/api/v1/sources/1/fetch" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/sources/1/fetch"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-sources--source_id--fetch">
</span>
<span id="execution-results-POSTapi-v1-sources--source_id--fetch" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-sources--source_id--fetch"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-sources--source_id--fetch"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-sources--source_id--fetch" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-sources--source_id--fetch">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-sources--source_id--fetch" data-method="POST"
      data-path="api/v1/sources/{source_id}/fetch"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-sources--source_id--fetch', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-sources--source_id--fetch"
                    onclick="tryItOut('POSTapi-v1-sources--source_id--fetch');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-sources--source_id--fetch"
                    onclick="cancelTryOut('POSTapi-v1-sources--source_id--fetch');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-sources--source_id--fetch"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/sources/{source_id}/fetch</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-sources--source_id--fetch"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-sources--source_id--fetch"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>source_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="source_id"                data-endpoint="POSTapi-v1-sources--source_id--fetch"
               value="1"
               data-component="url">
    <br>
<p>The ID of the source. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-v1-articles--article_id--analyze">POST api/v1/articles/{article_id}/analyze</h2>

<p>
</p>



<span id="example-requests-POSTapi-v1-articles--article_id--analyze">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8080/api/v1/articles/1/analyze" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8080/api/v1/articles/1/analyze"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-articles--article_id--analyze">
</span>
<span id="execution-results-POSTapi-v1-articles--article_id--analyze" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-articles--article_id--analyze"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-articles--article_id--analyze"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-articles--article_id--analyze" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-articles--article_id--analyze">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-articles--article_id--analyze" data-method="POST"
      data-path="api/v1/articles/{article_id}/analyze"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-articles--article_id--analyze', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-articles--article_id--analyze"
                    onclick="tryItOut('POSTapi-v1-articles--article_id--analyze');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-articles--article_id--analyze"
                    onclick="cancelTryOut('POSTapi-v1-articles--article_id--analyze');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-articles--article_id--analyze"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/articles/{article_id}/analyze</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-articles--article_id--analyze"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-articles--article_id--analyze"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>article_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="article_id"                data-endpoint="POSTapi-v1-articles--article_id--analyze"
               value="1"
               data-component="url">
    <br>
<p>The ID of the article. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
