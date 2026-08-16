<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>OptimaSync API Documentation</title>

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
        var tryItOutBaseUrl = "http://127.0.0.1:8000";
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
                    <ul id="tocify-header-authentication" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authentication">
                    <a href="#authentication">Authentication</a>
                </li>
                                    <ul id="tocify-subheader-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-register-email">
                                <a href="#authentication-POSTapi-v1-register-email">send email for authentication.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="authentication-POSTapi-v1-verify-otp">
                                <a href="#authentication-POSTapi-v1-verify-otp">verify otp to authenticate user.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-organizations" class="tocify-header">
                <li class="tocify-item level-1" data-unique="organizations">
                    <a href="#organizations">Organizations</a>
                </li>
                                    <ul id="tocify-subheader-organizations" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="organizations-GETapi-v1-organizations">
                                <a href="#organizations-GETapi-v1-organizations">get all Organizations</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-GETapi-v1-organizations-myOrgs">
                                <a href="#organizations-GETapi-v1-organizations-myOrgs">MyOrgs.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-POSTapi-v1-organizations">
                                <a href="#organizations-POSTapi-v1-organizations">create organization</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-PATCHapi-v1-organizations--id-">
                                <a href="#organizations-PATCHapi-v1-organizations--id-">Update organization</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-GETapi-v1-organizations--id-">
                                <a href="#organizations-GETapi-v1-organizations--id-">show the Organization</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-POSTapi-v1-organizations--organizationId--members">
                                <a href="#organizations-POSTapi-v1-organizations--organizationId--members">Add member to organization</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-PATCHapi-v1-organizations--organizationId--members--memberId-">
                                <a href="#organizations-PATCHapi-v1-organizations--organizationId--members--memberId-">update member role in organization</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="organizations-POSTapi-v1-organizations--organization_id--logo">
                                <a href="#organizations-POSTapi-v1-organizations--organization_id--logo">Upload logo to Organization</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-products" class="tocify-header">
                <li class="tocify-item level-1" data-unique="products">
                    <a href="#products">Products</a>
                </li>
                                    <ul id="tocify-subheader-products" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="products-GETapi-v1-products">
                                <a href="#products-GETapi-v1-products">Display Products.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-POSTapi-v1-products">
                                <a href="#products-POSTapi-v1-products">Store new Product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-GETapi-v1-products--id-">
                                <a href="#products-GETapi-v1-products--id-">Show Product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-PUTapi-v1-products--id-">
                                <a href="#products-PUTapi-v1-products--id-">Update Product.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="products-DELETEapi-v1-products--id-">
                                <a href="#products-DELETEapi-v1-products--id-">Delete Product.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-connections" class="tocify-header">
                <li class="tocify-item level-1" data-unique="connections">
                    <a href="#connections">Connections</a>
                </li>
                                    <ul id="tocify-subheader-connections" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="connections-POSTapi-v1-clients--client_id--connections">
                                <a href="#connections-POSTapi-v1-clients--client_id--connections">Store a newly created resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="connections-GETapi-v1-connections">
                                <a href="#connections-GETapi-v1-connections">Display a listing of the resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="connections-GETapi-v1-clients--client_id--connections">
                                <a href="#connections-GETapi-v1-clients--client_id--connections">GET api/v1/clients/{client_id}/connections</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="connections-GETapi-v1-connections--connection_id-">
                                <a href="#connections-GETapi-v1-connections--connection_id-">Display the specified resource.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="connections-PATCHapi-v1-connections--connection_id-">
                                <a href="#connections-PATCHapi-v1-connections--connection_id-">Update the specified resource in storage.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="connections-DELETEapi-v1-connections--connection_id-">
                                <a href="#connections-DELETEapi-v1-connections--connection_id-">Remove the specified resource from storage.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-clients" class="tocify-header">
                <li class="tocify-item level-1" data-unique="clients">
                    <a href="#clients">Clients</a>
                </li>
                                    <ul id="tocify-subheader-clients" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="clients-POSTapi-v1-clients">
                                <a href="#clients-POSTapi-v1-clients">create client.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-PATCHapi-v1-clients--client_id-">
                                <a href="#clients-PATCHapi-v1-clients--client_id-">Update client.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="clients-GETapi-v1-clients">
                                <a href="#clients-GETapi-v1-clients">Display a listing of the resource.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-industries" class="tocify-header">
                <li class="tocify-item level-1" data-unique="industries">
                    <a href="#industries">Industries</a>
                </li>
                                    <ul id="tocify-subheader-industries" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="industries-GETapi-v1-industries">
                                <a href="#industries-GETapi-v1-industries">Display all Industries.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="industries-POSTapi-v1-industries">
                                <a href="#industries-POSTapi-v1-industries">Store industry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="industries-PATCHapi-v1-industries--industry_id-">
                                <a href="#industries-PATCHapi-v1-industries--industry_id-">Update industry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="industries-DELETEapi-v1-industries--industry_id-">
                                <a href="#industries-DELETEapi-v1-industries--industry_id-">Delete industry.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-cities" class="tocify-header">
                <li class="tocify-item level-1" data-unique="cities">
                    <a href="#cities">Cities</a>
                </li>
                                    <ul id="tocify-subheader-cities" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="cities-GETapi-v1-cities">
                                <a href="#cities-GETapi-v1-cities">Display a listing of the cities.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cities-POSTapi-v1-cities">
                                <a href="#cities-POSTapi-v1-cities">create city.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cities-PATCHapi-v1-cities--city_id-">
                                <a href="#cities-PATCHapi-v1-cities--city_id-">Update city.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="cities-DELETEapi-v1-cities--city_id-">
                                <a href="#cities-DELETEapi-v1-cities--city_id-">Delete city.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-channels" class="tocify-header">
                <li class="tocify-item level-1" data-unique="channels">
                    <a href="#channels">Channels</a>
                </li>
                                    <ul id="tocify-subheader-channels" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="channels-GETapi-v1-channels">
                                <a href="#channels-GETapi-v1-channels">Display a listing of the channels.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="channels-POSTapi-v1-channels">
                                <a href="#channels-POSTapi-v1-channels">create channel.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="channels-PATCHapi-v1-channels--channel_id-">
                                <a href="#channels-PATCHapi-v1-channels--channel_id-">Update channel.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="channels-DELETEapi-v1-channels--channel_id-">
                                <a href="#channels-DELETEapi-v1-channels--channel_id-">Delete channel.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-stakeholder" class="tocify-header">
                <li class="tocify-item level-1" data-unique="stakeholder">
                    <a href="#stakeholder">Stakeholder</a>
                </li>
                                    <ul id="tocify-subheader-stakeholder" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="stakeholder-GETapi-v1-clients--client_id--stakeholders">
                                <a href="#stakeholder-GETapi-v1-clients--client_id--stakeholders">Display all Stakeholders.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stakeholder-POSTapi-v1-clients--client_id--stakeholders">
                                <a href="#stakeholder-POSTapi-v1-clients--client_id--stakeholders">create Stakeholder.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stakeholder-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">
                                <a href="#stakeholder-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">Update Stakeholder.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="stakeholder-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">
                                <a href="#stakeholder-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">Delete Stakeholder.</a>
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
        <li>Last updated: August 16, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://127.0.0.1:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {ACCESS_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>You can retrieve your token by visiting your dashboard and clicking <b>Generate API token</b>.</p>

        <h1 id="authentication">Authentication</h1>

    

                                <h2 id="authentication-POSTapi-v1-register-email">send email for authentication.</h2>

<p>
</p>

<p>Store a newly created email in storage &amp; OTP sent to your email</p>

<span id="example-requests-POSTapi-v1-register-email">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/register-email" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"email\": \"user@example.com\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/register-email"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "email": "user@example.com"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-register-email">
</span>
<span id="execution-results-POSTapi-v1-register-email" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-register-email"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-register-email"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-register-email" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-register-email">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-register-email" data-method="POST"
      data-path="api/v1/register-email"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-register-email', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-register-email"
                    onclick="tryItOut('POSTapi-v1-register-email');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-register-email"
                    onclick="cancelTryOut('POSTapi-v1-register-email');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-register-email"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/register-email</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-register-email"
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
                              name="Accept"                data-endpoint="POSTapi-v1-register-email"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-register-email"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-register-email"
               value="user@example.com"
               data-component="body">
    <br>
<p>The email address to send OTP to. Must be a valid email address. Example: <code>user@example.com</code></p>
        </div>
        </form>

                    <h2 id="authentication-POSTapi-v1-verify-otp">verify otp to authenticate user.</h2>

<p>
</p>

<p>login or register the user via otp</p>

<span id="example-requests-POSTapi-v1-verify-otp">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/verify-otp" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"email\": \"user@example.com\",
    \"otp\": \"123456\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/verify-otp"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "email": "user@example.com",
    "otp": "123456"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-verify-otp">
</span>
<span id="execution-results-POSTapi-v1-verify-otp" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-verify-otp"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-verify-otp"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-verify-otp" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-verify-otp">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-verify-otp" data-method="POST"
      data-path="api/v1/verify-otp"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-verify-otp', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-verify-otp"
                    onclick="tryItOut('POSTapi-v1-verify-otp');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-verify-otp"
                    onclick="cancelTryOut('POSTapi-v1-verify-otp');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-verify-otp"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/verify-otp</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-verify-otp"
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
                              name="Accept"                data-endpoint="POSTapi-v1-verify-otp"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-verify-otp"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-verify-otp"
               value="user@example.com"
               data-component="body">
    <br>
<p>The email address. Must be a valid email address. Example: <code>user@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>otp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="otp"                data-endpoint="POSTapi-v1-verify-otp"
               value="123456"
               data-component="body">
    <br>
<p>The OTP code received via email. Must be at least 6 characters. Must not be greater than 6 characters. Example: <code>123456</code></p>
        </div>
        </form>

                <h1 id="organizations">Organizations</h1>

    

                                <h2 id="organizations-GETapi-v1-organizations">get all Organizations</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-organizations">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/organizations" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-organizations">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-organizations" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-organizations"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-organizations"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-organizations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-organizations">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-organizations" data-method="GET"
      data-path="api/v1/organizations"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-organizations', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-organizations"
                    onclick="tryItOut('GETapi-v1-organizations');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-organizations"
                    onclick="cancelTryOut('GETapi-v1-organizations');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-organizations"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/organizations</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-organizations"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-organizations"
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
                              name="Accept"                data-endpoint="GETapi-v1-organizations"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-organizations"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="organizations-GETapi-v1-organizations-myOrgs">MyOrgs.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>show a list of orginaztions that the user is a member of</p>

<span id="example-requests-GETapi-v1-organizations-myOrgs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/organizations/myOrgs" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/myOrgs"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-organizations-myOrgs">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-organizations-myOrgs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-organizations-myOrgs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-organizations-myOrgs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-organizations-myOrgs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-organizations-myOrgs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-organizations-myOrgs" data-method="GET"
      data-path="api/v1/organizations/myOrgs"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-organizations-myOrgs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-organizations-myOrgs"
                    onclick="tryItOut('GETapi-v1-organizations-myOrgs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-organizations-myOrgs"
                    onclick="cancelTryOut('GETapi-v1-organizations-myOrgs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-organizations-myOrgs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/organizations/myOrgs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-organizations-myOrgs"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-organizations-myOrgs"
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
                              name="Accept"                data-endpoint="GETapi-v1-organizations-myOrgs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-organizations-myOrgs"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="organizations-POSTapi-v1-organizations">create organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint create new organization
response new organization</p>

<span id="example-requests-POSTapi-v1-organizations">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/organizations" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"phone\": \"+08s790-\",
    \"description\": \"Quo omnis nostrum aut adipisci.\",
    \"address\": \"p\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "phone": "+08s790-",
    "description": "Quo omnis nostrum aut adipisci.",
    "address": "p"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-organizations">
</span>
<span id="execution-results-POSTapi-v1-organizations" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-organizations"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-organizations"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-organizations" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-organizations">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-organizations" data-method="POST"
      data-path="api/v1/organizations"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-organizations', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-organizations"
                    onclick="tryItOut('POSTapi-v1-organizations');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-organizations"
                    onclick="cancelTryOut('POSTapi-v1-organizations');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-organizations"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/organizations</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-organizations"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-organizations"
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
                              name="Accept"                data-endpoint="POSTapi-v1-organizations"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-organizations"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-organizations"
               value="b"
               data-component="body">
    <br>
<p>Must be at least 3 characters. Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-organizations"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-organizations"
               value="+08s790-"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Example: <code>+08s790-</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-v1-organizations"
               value="Quo omnis nostrum aut adipisci."
               data-component="body">
    <br>
<p>Must be at least 10 characters. Must not be greater than 500 characters. Example: <code>Quo omnis nostrum aut adipisci.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-v1-organizations"
               value="p"
               data-component="body">
    <br>
<p>Must be at least 5 characters. Must not be greater than 255 characters. Example: <code>p</code></p>
        </div>
        </form>

                    <h2 id="organizations-PATCHapi-v1-organizations--id-">Update organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint update organization data
response updated organization data</p>

<span id="example-requests-PATCHapi-v1-organizations--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/organizations/architecto" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"email\": \"zbailey@example.net\",
    \"phone\": \"+08s790-\",
    \"description\": \"Quo omnis nostrum aut adipisci.\",
    \"address\": \"p\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/architecto"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "email": "zbailey@example.net",
    "phone": "+08s790-",
    "description": "Quo omnis nostrum aut adipisci.",
    "address": "p"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-organizations--id-">
</span>
<span id="execution-results-PATCHapi-v1-organizations--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-organizations--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-organizations--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-organizations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-organizations--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-organizations--id-" data-method="PATCH"
      data-path="api/v1/organizations/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-organizations--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-organizations--id-"
                    onclick="tryItOut('PATCHapi-v1-organizations--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-organizations--id-"
                    onclick="cancelTryOut('PATCHapi-v1-organizations--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-organizations--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/organizations/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-organizations--id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-organizations--id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the organization. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="b"
               data-component="body">
    <br>
<p>Must be at least 3 characters. Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="zbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>zbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="+08s790-"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Example: <code>+08s790-</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="Quo omnis nostrum aut adipisci."
               data-component="body">
    <br>
<p>Must be at least 10 characters. Must not be greater than 500 characters. Example: <code>Quo omnis nostrum aut adipisci.</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="PATCHapi-v1-organizations--id-"
               value="p"
               data-component="body">
    <br>
<p>Must be at least 5 characters. Must not be greater than 255 characters. Example: <code>p</code></p>
        </div>
        </form>

                    <h2 id="organizations-GETapi-v1-organizations--id-">show the Organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-organizations--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/organizations/architecto" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/architecto"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-organizations--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-organizations--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-organizations--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-organizations--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-organizations--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-organizations--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-organizations--id-" data-method="GET"
      data-path="api/v1/organizations/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-organizations--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-organizations--id-"
                    onclick="tryItOut('GETapi-v1-organizations--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-organizations--id-"
                    onclick="cancelTryOut('GETapi-v1-organizations--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-organizations--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/organizations/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-organizations--id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-organizations--id-"
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
                              name="Accept"                data-endpoint="GETapi-v1-organizations--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-organizations--id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-v1-organizations--id-"
               value="architecto"
               data-component="url">
    <br>
<p>The ID of the organization. Example: <code>architecto</code></p>
            </div>
                    </form>

                    <h2 id="organizations-POSTapi-v1-organizations--organizationId--members">Add member to organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint add new member to organization
response updated organization data</p>

<span id="example-requests-POSTapi-v1-organizations--organizationId--members">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/organizations/architecto/members" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"role\": \"member\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/architecto/members"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "email": "gbailey@example.net",
    "role": "member"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-organizations--organizationId--members">
</span>
<span id="execution-results-POSTapi-v1-organizations--organizationId--members" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-organizations--organizationId--members"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-organizations--organizationId--members"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-organizations--organizationId--members" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-organizations--organizationId--members">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-organizations--organizationId--members" data-method="POST"
      data-path="api/v1/organizations/{organizationId}/members"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-organizations--organizationId--members', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-organizations--organizationId--members"
                    onclick="tryItOut('POSTapi-v1-organizations--organizationId--members');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-organizations--organizationId--members"
                    onclick="cancelTryOut('POSTapi-v1-organizations--organizationId--members');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-organizations--organizationId--members"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/organizations/{organizationId}/members</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
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
                              name="Accept"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>organizationId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="organizationId"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>role</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="role"                data-endpoint="POSTapi-v1-organizations--organizationId--members"
               value="member"
               data-component="body">
    <br>
<p>Example: <code>member</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>admin</code></li> <li><code>member</code></li></ul>
        </div>
        </form>

                    <h2 id="organizations-PATCHapi-v1-organizations--organizationId--members--memberId-">update member role in organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PATCHapi-v1-organizations--organizationId--members--memberId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/organizations/architecto/members/architecto" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"role\": \"admin\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/architecto/members/architecto"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "role": "admin"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-organizations--organizationId--members--memberId-">
</span>
<span id="execution-results-PATCHapi-v1-organizations--organizationId--members--memberId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-organizations--organizationId--members--memberId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-organizations--organizationId--members--memberId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-organizations--organizationId--members--memberId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-organizations--organizationId--members--memberId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-organizations--organizationId--members--memberId-" data-method="PATCH"
      data-path="api/v1/organizations/{organizationId}/members/{memberId}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-organizations--organizationId--members--memberId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-organizations--organizationId--members--memberId-"
                    onclick="tryItOut('PATCHapi-v1-organizations--organizationId--members--memberId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-organizations--organizationId--members--memberId-"
                    onclick="cancelTryOut('PATCHapi-v1-organizations--organizationId--members--memberId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-organizations--organizationId--members--memberId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/organizations/{organizationId}/members/{memberId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>organizationId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="organizationId"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>memberId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="memberId"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>role</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="role"                data-endpoint="PATCHapi-v1-organizations--organizationId--members--memberId-"
               value="admin"
               data-component="body">
    <br>
<p>Example: <code>admin</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>admin</code></li> <li><code>member</code></li></ul>
        </div>
        </form>

                    <h2 id="organizations-POSTapi-v1-organizations--organization_id--logo">Upload logo to Organization</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-organizations--organization_id--logo">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/organizations/1/logo" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --form "logo=@C:\Users\wadah\AppData\Local\Temp\phpB1C9.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/organizations/1/logo"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

const body = new FormData();
body.append('logo', document.querySelector('input[name="logo"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-organizations--organization_id--logo">
</span>
<span id="execution-results-POSTapi-v1-organizations--organization_id--logo" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-organizations--organization_id--logo"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-organizations--organization_id--logo"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-organizations--organization_id--logo" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-organizations--organization_id--logo">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-organizations--organization_id--logo" data-method="POST"
      data-path="api/v1/organizations/{organization_id}/logo"
      data-authed="1"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-organizations--organization_id--logo', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-organizations--organization_id--logo"
                    onclick="tryItOut('POSTapi-v1-organizations--organization_id--logo');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-organizations--organization_id--logo"
                    onclick="cancelTryOut('POSTapi-v1-organizations--organization_id--logo');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-organizations--organization_id--logo"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/organizations/{organization_id}/logo</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>organization_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="organization_id"                data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value="1"
               data-component="url">
    <br>
<p>The ID of the organization. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>logo</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="logo"                data-endpoint="POSTapi-v1-organizations--organization_id--logo"
               value=""
               data-component="body">
    <br>
<p>Must be a file. Must not be greater than 5120 kilobytes. Example: <code>C:\Users\wadah\AppData\Local\Temp\phpB1C9.tmp</code></p>
        </div>
        </form>

                <h1 id="products">Products</h1>

    

                                <h2 id="products-GETapi-v1-products">Display Products.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>show a list of latest added products with pagination</p>

<span id="example-requests-GETapi-v1-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/products" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-products">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-products" data-method="GET"
      data-path="api/v1/products"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-products"
                    onclick="tryItOut('GETapi-v1-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-products"
                    onclick="cancelTryOut('GETapi-v1-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-products"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-products"
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
                              name="Accept"                data-endpoint="GETapi-v1-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-products"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="products-POSTapi-v1-products">Store new Product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-products">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/products" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"price\": 4326.41688,
    \"description\": \"Velit et fugiat sunt nihil accusantium.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "price": 4326.41688,
    "description": "Velit et fugiat sunt nihil accusantium."
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-products">
</span>
<span id="execution-results-POSTapi-v1-products" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-products"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-products"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-products">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-products" data-method="POST"
      data-path="api/v1/products"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-products', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-products"
                    onclick="tryItOut('POSTapi-v1-products');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-products"
                    onclick="cancelTryOut('POSTapi-v1-products');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-products"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/products</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-products"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-products"
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
                              name="Accept"                data-endpoint="POSTapi-v1-products"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-products"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-products"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="POSTapi-v1-products"
               value="4326.41688"
               data-component="body">
    <br>
<p>Example: <code>4326.41688</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="POSTapi-v1-products"
               value="Velit et fugiat sunt nihil accusantium."
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>Velit et fugiat sunt nihil accusantium.</code></p>
        </div>
        </form>

                    <h2 id="products-GETapi-v1-products--id-">Show Product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/products/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-products--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-products--id-" data-method="GET"
      data-path="api/v1/products/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-products--id-"
                    onclick="tryItOut('GETapi-v1-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-products--id-"
                    onclick="cancelTryOut('GETapi-v1-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-products--id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-products--id-"
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
                              name="Accept"                data-endpoint="GETapi-v1-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-products--id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-products--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="products-PUTapi-v1-products--id-">Update Product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-v1-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://127.0.0.1:8000/api/v1/products/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"price\": 4326.41688,
    \"description\": \"Velit et fugiat sunt nihil accusantium.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "price": 4326.41688,
    "description": "Velit et fugiat sunt nihil accusantium."
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-products--id-">
</span>
<span id="execution-results-PUTapi-v1-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-products--id-" data-method="PUT"
      data-path="api/v1/products/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-products--id-"
                    onclick="tryItOut('PUTapi-v1-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-products--id-"
                    onclick="cancelTryOut('PUTapi-v1-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/products/{id}</code></b>
        </p>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-products--id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-products--id-"
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
                              name="Accept"                data-endpoint="PUTapi-v1-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PUTapi-v1-products--id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-v1-products--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PUTapi-v1-products--id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>price</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="price"                data-endpoint="PUTapi-v1-products--id-"
               value="4326.41688"
               data-component="body">
    <br>
<p>Example: <code>4326.41688</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="description"                data-endpoint="PUTapi-v1-products--id-"
               value="Velit et fugiat sunt nihil accusantium."
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>Velit et fugiat sunt nihil accusantium.</code></p>
        </div>
        </form>

                    <h2 id="products-DELETEapi-v1-products--id-">Delete Product.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-products--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/products/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/products/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-products--id-">
</span>
<span id="execution-results-DELETEapi-v1-products--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-products--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-products--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-products--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-products--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-products--id-" data-method="DELETE"
      data-path="api/v1/products/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-products--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-products--id-"
                    onclick="tryItOut('DELETEapi-v1-products--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-products--id-"
                    onclick="cancelTryOut('DELETEapi-v1-products--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-products--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/products/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-products--id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-products--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-products--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-products--id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-products--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the product. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="connections">Connections</h1>

    

                                <h2 id="connections-POSTapi-v1-clients--client_id--connections">Store a newly created resource in storage.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-clients--client_id--connections">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/clients/1/connections" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"product_id\": \"architecto\",
    \"stage\": \"intrested\",
    \"initiated_by\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/connections"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "product_id": "architecto",
    "stage": "intrested",
    "initiated_by": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-clients--client_id--connections">
</span>
<span id="execution-results-POSTapi-v1-clients--client_id--connections" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-clients--client_id--connections"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-clients--client_id--connections"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-clients--client_id--connections" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-clients--client_id--connections">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-clients--client_id--connections" data-method="POST"
      data-path="api/v1/clients/{client_id}/connections"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-clients--client_id--connections', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-clients--client_id--connections"
                    onclick="tryItOut('POSTapi-v1-clients--client_id--connections');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-clients--client_id--connections"
                    onclick="cancelTryOut('POSTapi-v1-clients--client_id--connections');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-clients--client_id--connections"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/clients/{client_id}/connections</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-clients--client_id--connections"
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
                              name="Accept"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>product_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="product_id"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="architecto"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>stage</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stage"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="intrested"
               data-component="body">
    <br>
<p>Example: <code>intrested</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>lead</code></li> <li><code>conected</code></li> <li><code>missing_info</code></li> <li><code>intrested</code></li> <li><code>not_intrested</code></li> <li><code>win</code></li> <li><code>closed</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>channel_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="channel_id"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value=""
               data-component="body">
    <br>
<p>Must match an existing stored value.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>assignee_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="assignee_id"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value=""
               data-component="body">
    <br>
<p>Must match an existing stored value.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>initiated_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="initiated_by"                data-endpoint="POSTapi-v1-clients--client_id--connections"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="connections-GETapi-v1-connections">Display a listing of the resource.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-connections">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/connections" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/connections"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-connections">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-connections" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-connections"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-connections"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-connections" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-connections">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-connections" data-method="GET"
      data-path="api/v1/connections"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-connections', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-connections"
                    onclick="tryItOut('GETapi-v1-connections');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-connections"
                    onclick="cancelTryOut('GETapi-v1-connections');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-connections"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/connections</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-connections"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-connections"
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
                              name="Accept"                data-endpoint="GETapi-v1-connections"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-connections"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="connections-GETapi-v1-clients--client_id--connections">GET api/v1/clients/{client_id}/connections</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-clients--client_id--connections">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/clients/1/connections" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/connections"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-clients--client_id--connections">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-clients--client_id--connections" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-clients--client_id--connections"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-clients--client_id--connections"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-clients--client_id--connections" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-clients--client_id--connections">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-clients--client_id--connections" data-method="GET"
      data-path="api/v1/clients/{client_id}/connections"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-clients--client_id--connections', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-clients--client_id--connections"
                    onclick="tryItOut('GETapi-v1-clients--client_id--connections');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-clients--client_id--connections"
                    onclick="cancelTryOut('GETapi-v1-clients--client_id--connections');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-clients--client_id--connections"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/clients/{client_id}/connections</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-clients--client_id--connections"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-clients--client_id--connections"
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
                              name="Accept"                data-endpoint="GETapi-v1-clients--client_id--connections"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-clients--client_id--connections"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="GETapi-v1-clients--client_id--connections"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="connections-GETapi-v1-connections--connection_id-">Display the specified resource.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-connections--connection_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/connections/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/connections/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-connections--connection_id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-connections--connection_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-connections--connection_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-connections--connection_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-connections--connection_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-connections--connection_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-connections--connection_id-" data-method="GET"
      data-path="api/v1/connections/{connection_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-connections--connection_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-connections--connection_id-"
                    onclick="tryItOut('GETapi-v1-connections--connection_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-connections--connection_id-"
                    onclick="cancelTryOut('GETapi-v1-connections--connection_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-connections--connection_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/connections/{connection_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-connections--connection_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-connections--connection_id-"
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
                              name="Accept"                data-endpoint="GETapi-v1-connections--connection_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-connections--connection_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>connection_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="connection_id"                data-endpoint="GETapi-v1-connections--connection_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the connection. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="connections-PATCHapi-v1-connections--connection_id-">Update the specified resource in storage.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PATCHapi-v1-connections--connection_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/connections/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"stage\": \"lead\",
    \"channel_id\": \"architecto\",
    \"assignee_id\": \"architecto\",
    \"initiated_by\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/connections/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "stage": "lead",
    "channel_id": "architecto",
    "assignee_id": "architecto",
    "initiated_by": "architecto"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-connections--connection_id-">
</span>
<span id="execution-results-PATCHapi-v1-connections--connection_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-connections--connection_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-connections--connection_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-connections--connection_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-connections--connection_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-connections--connection_id-" data-method="PATCH"
      data-path="api/v1/connections/{connection_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-connections--connection_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-connections--connection_id-"
                    onclick="tryItOut('PATCHapi-v1-connections--connection_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-connections--connection_id-"
                    onclick="cancelTryOut('PATCHapi-v1-connections--connection_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-connections--connection_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/connections/{connection_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-connections--connection_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>connection_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="connection_id"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the connection. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>stage</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="stage"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="lead"
               data-component="body">
    <br>
<p>Example: <code>lead</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>lead</code></li> <li><code>conected</code></li> <li><code>missing_info</code></li> <li><code>intrested</code></li> <li><code>not_intrested</code></li> <li><code>win</code></li> <li><code>closed</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>channel_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="channel_id"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="architecto"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>assignee_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="assignee_id"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="architecto"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>initiated_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="initiated_by"                data-endpoint="PATCHapi-v1-connections--connection_id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="connections-DELETEapi-v1-connections--connection_id-">Remove the specified resource from storage.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-connections--connection_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/connections/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/connections/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-connections--connection_id-">
</span>
<span id="execution-results-DELETEapi-v1-connections--connection_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-connections--connection_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-connections--connection_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-connections--connection_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-connections--connection_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-connections--connection_id-" data-method="DELETE"
      data-path="api/v1/connections/{connection_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-connections--connection_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-connections--connection_id-"
                    onclick="tryItOut('DELETEapi-v1-connections--connection_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-connections--connection_id-"
                    onclick="cancelTryOut('DELETEapi-v1-connections--connection_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-connections--connection_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/connections/{connection_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-connections--connection_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-connections--connection_id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-connections--connection_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-connections--connection_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>connection_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="connection_id"                data-endpoint="DELETEapi-v1-connections--connection_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the connection. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="clients">Clients</h1>

    

                                <h2 id="clients-POSTapi-v1-clients">create client.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint create new client
response new client</p>

<span id="example-requests-POSTapi-v1-clients">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/clients" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"client_type\": \"individual\",
    \"industry_id\": 16,
    \"city_id\": 16,
    \"phone\": \"n\",
    \"email\": \"ashly64@example.com\",
    \"address\": \"architecto\",
    \"whatsapp\": \"n\",
    \"facebook\": \"g\",
    \"instagram\": \"z\",
    \"website\": \"m\",
    \"notes\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "client_type": "individual",
    "industry_id": 16,
    "city_id": 16,
    "phone": "n",
    "email": "ashly64@example.com",
    "address": "architecto",
    "whatsapp": "n",
    "facebook": "g",
    "instagram": "z",
    "website": "m",
    "notes": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-clients">
</span>
<span id="execution-results-POSTapi-v1-clients" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-clients"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-clients"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-clients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-clients">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-clients" data-method="POST"
      data-path="api/v1/clients"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-clients', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-clients"
                    onclick="tryItOut('POSTapi-v1-clients');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-clients"
                    onclick="cancelTryOut('POSTapi-v1-clients');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-clients"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/clients</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-clients"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-clients"
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
                              name="Accept"                data-endpoint="POSTapi-v1-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-clients"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-clients"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type"                data-endpoint="POSTapi-v1-clients"
               value="individual"
               data-component="body">
    <br>
<p>Example: <code>individual</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>company</code></li> <li><code>individual</code></li> <li><code>government</code></li> <li><code>charity</code></li> <li><code>agency</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>industry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="industry_id"                data-endpoint="POSTapi-v1-clients"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="POSTapi-v1-clients"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-clients"
               value="n"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-v1-clients"
               value="ashly64@example.com"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>ashly64@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="POSTapi-v1-clients"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>whatsapp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="whatsapp"                data-endpoint="POSTapi-v1-clients"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>facebook</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="facebook"                data-endpoint="POSTapi-v1-clients"
               value="g"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>instagram</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="instagram"                data-endpoint="POSTapi-v1-clients"
               value="z"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>website</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="website"                data-endpoint="POSTapi-v1-clients"
               value="m"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="POSTapi-v1-clients"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="clients-PATCHapi-v1-clients--client_id-">Update client.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint update client data
response updated client data</p>

<span id="example-requests-PATCHapi-v1-clients--client_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/clients/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"client_type\": \"company\",
    \"industry_id\": 16,
    \"city_id\": 16,
    \"phone\": \"n\",
    \"email\": \"ashly64@example.com\",
    \"address\": \"architecto\",
    \"whatsapp\": \"n\",
    \"facebook\": \"g\",
    \"instagram\": \"z\",
    \"website\": \"m\",
    \"notes\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "client_type": "company",
    "industry_id": 16,
    "city_id": 16,
    "phone": "n",
    "email": "ashly64@example.com",
    "address": "architecto",
    "whatsapp": "n",
    "facebook": "g",
    "instagram": "z",
    "website": "m",
    "notes": "architecto"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-clients--client_id-">
</span>
<span id="execution-results-PATCHapi-v1-clients--client_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-clients--client_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-clients--client_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-clients--client_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-clients--client_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-clients--client_id-" data-method="PATCH"
      data-path="api/v1/clients/{client_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-clients--client_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-clients--client_id-"
                    onclick="tryItOut('PATCHapi-v1-clients--client_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-clients--client_id-"
                    onclick="cancelTryOut('PATCHapi-v1-clients--client_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-clients--client_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/clients/{client_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-clients--client_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-clients--client_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="company"
               data-component="body">
    <br>
<p>Example: <code>company</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>company</code></li> <li><code>individual</code></li> <li><code>government</code></li> <li><code>charity</code></li> <li><code>agency</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>industry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="industry_id"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="n"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="ashly64@example.com"
               data-component="body">
    <br>
<p>Must be a valid email address. Must not be greater than 255 characters. Example: <code>ashly64@example.com</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>address</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="address"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>whatsapp</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="whatsapp"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>facebook</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="facebook"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="g"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>instagram</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="instagram"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="z"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>z</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>website</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="website"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="m"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="notes"                data-endpoint="PATCHapi-v1-clients--client_id-"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="clients-GETapi-v1-clients">Display a listing of the resource.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-clients">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/clients" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"search\": {
        \"name\": \"b\",
        \"contact_info\": \"n\"
    },
    \"city_id\": 16,
    \"industry_id\": 16,
    \"client_type\": \"architecto\",
    \"per_page\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "search": {
        "name": "b",
        "contact_info": "n"
    },
    "city_id": 16,
    "industry_id": 16,
    "client_type": "architecto",
    "per_page": 22
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-clients">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-clients" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-clients"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-clients"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-clients" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-clients">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-clients" data-method="GET"
      data-path="api/v1/clients"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-clients', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-clients"
                    onclick="tryItOut('GETapi-v1-clients');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-clients"
                    onclick="cancelTryOut('GETapi-v1-clients');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-clients"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/clients</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-clients"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-clients"
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
                              name="Accept"                data-endpoint="GETapi-v1-clients"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-clients"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
<br>

            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search.name"                data-endpoint="GETapi-v1-clients"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>contact_info</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="search.contact_info"                data-endpoint="GETapi-v1-clients"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="GETapi-v1-clients"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>industry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="industry_id"                data-endpoint="GETapi-v1-clients"
               value="16"
               data-component="body">
    <br>
<p>Must match an existing stored value. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>client_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="client_type"                data-endpoint="GETapi-v1-clients"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-clients"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>22</code></p>
        </div>
        </form>

                <h1 id="industries">Industries</h1>

    

                                <h2 id="industries-GETapi-v1-industries">Display all Industries.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-industries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/industries" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/industries"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-industries">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-industries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-industries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-industries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-industries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-industries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-industries" data-method="GET"
      data-path="api/v1/industries"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-industries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-industries"
                    onclick="tryItOut('GETapi-v1-industries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-industries"
                    onclick="cancelTryOut('GETapi-v1-industries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-industries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/industries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-industries"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-industries"
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
                              name="Accept"                data-endpoint="GETapi-v1-industries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-industries"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="industries-POSTapi-v1-industries">Store industry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-industries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/industries" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"Technology\",
    \"color\": \"#33FF57\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/industries"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "Technology",
    "color": "#33FF57"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-industries">
</span>
<span id="execution-results-POSTapi-v1-industries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-industries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-industries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-industries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-industries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-industries" data-method="POST"
      data-path="api/v1/industries"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-industries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-industries"
                    onclick="tryItOut('POSTapi-v1-industries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-industries"
                    onclick="cancelTryOut('POSTapi-v1-industries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-industries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/industries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-industries"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-industries"
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
                              name="Accept"                data-endpoint="POSTapi-v1-industries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-industries"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-industries"
               value="Technology"
               data-component="body">
    <br>
<p>The name of the industry. Must not be greater than 255 characters. Example: <code>Technology</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="POSTapi-v1-industries"
               value="#33FF57"
               data-component="body">
    <br>
<p>The color associated with the industry. Example: <code>#33FF57</code></p>
        </div>
        </form>

                    <h2 id="industries-PATCHapi-v1-industries--industry_id-">Update industry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PATCHapi-v1-industries--industry_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/industries/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"Technology\",
    \"color\": \"#33FF57\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/industries/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "Technology",
    "color": "#33FF57"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-industries--industry_id-">
</span>
<span id="execution-results-PATCHapi-v1-industries--industry_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-industries--industry_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-industries--industry_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-industries--industry_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-industries--industry_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-industries--industry_id-" data-method="PATCH"
      data-path="api/v1/industries/{industry_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-industries--industry_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-industries--industry_id-"
                    onclick="tryItOut('PATCHapi-v1-industries--industry_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-industries--industry_id-"
                    onclick="cancelTryOut('PATCHapi-v1-industries--industry_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-industries--industry_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/industries/{industry_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-industries--industry_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>industry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="industry_id"                data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the industry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="Technology"
               data-component="body">
    <br>
<p>The name of the industry. Must not be greater than 255 characters. Example: <code>Technology</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="PATCHapi-v1-industries--industry_id-"
               value="#33FF57"
               data-component="body">
    <br>
<p>The color associated with the industry. Example: <code>#33FF57</code></p>
        </div>
        </form>

                    <h2 id="industries-DELETEapi-v1-industries--industry_id-">Delete industry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-industries--industry_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/industries/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/industries/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-industries--industry_id-">
</span>
<span id="execution-results-DELETEapi-v1-industries--industry_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-industries--industry_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-industries--industry_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-industries--industry_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-industries--industry_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-industries--industry_id-" data-method="DELETE"
      data-path="api/v1/industries/{industry_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-industries--industry_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-industries--industry_id-"
                    onclick="tryItOut('DELETEapi-v1-industries--industry_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-industries--industry_id-"
                    onclick="cancelTryOut('DELETEapi-v1-industries--industry_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-industries--industry_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/industries/{industry_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-industries--industry_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-industries--industry_id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-industries--industry_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-industries--industry_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>industry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="industry_id"                data-endpoint="DELETEapi-v1-industries--industry_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the industry. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="cities">Cities</h1>

    

                                <h2 id="cities-GETapi-v1-cities">Display a listing of the cities.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint display all cities from DB
response get all cities</p>

<span id="example-requests-GETapi-v1-cities">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/cities" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cities"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-cities">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-cities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-cities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-cities"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-cities">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-cities" data-method="GET"
      data-path="api/v1/cities"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-cities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-cities"
                    onclick="tryItOut('GETapi-v1-cities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-cities"
                    onclick="cancelTryOut('GETapi-v1-cities');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-cities"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/cities</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-cities"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-cities"
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
                              name="Accept"                data-endpoint="GETapi-v1-cities"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-cities"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="cities-POSTapi-v1-cities">create city.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint create new city
response new city</p>

<span id="example-requests-POSTapi-v1-cities">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/cities" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"New York\",
    \"color\": \"#FF5733\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cities"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "New York",
    "color": "#FF5733"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-cities">
</span>
<span id="execution-results-POSTapi-v1-cities" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-cities"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-cities"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-cities" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-cities">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-cities" data-method="POST"
      data-path="api/v1/cities"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-cities', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-cities"
                    onclick="tryItOut('POSTapi-v1-cities');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-cities"
                    onclick="cancelTryOut('POSTapi-v1-cities');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-cities"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/cities</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-cities"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-cities"
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
                              name="Accept"                data-endpoint="POSTapi-v1-cities"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-cities"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-cities"
               value="New York"
               data-component="body">
    <br>
<p>The name of the city. Must not be greater than 255 characters. Example: <code>New York</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="POSTapi-v1-cities"
               value="#FF5733"
               data-component="body">
    <br>
<p>The color associated with the city. Example: <code>#FF5733</code></p>
        </div>
        </form>

                    <h2 id="cities-PATCHapi-v1-cities--city_id-">Update city.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint update city data
response updated city data</p>

<span id="example-requests-PATCHapi-v1-cities--city_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/cities/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"New York\",
    \"color\": \"#FF5733\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cities/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "New York",
    "color": "#FF5733"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-cities--city_id-">
</span>
<span id="execution-results-PATCHapi-v1-cities--city_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-cities--city_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-cities--city_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-cities--city_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-cities--city_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-cities--city_id-" data-method="PATCH"
      data-path="api/v1/cities/{city_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-cities--city_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-cities--city_id-"
                    onclick="tryItOut('PATCHapi-v1-cities--city_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-cities--city_id-"
                    onclick="cancelTryOut('PATCHapi-v1-cities--city_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-cities--city_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/cities/{city_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-cities--city_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-cities--city_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-cities--city_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-cities--city_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="PATCHapi-v1-cities--city_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the city. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-cities--city_id-"
               value="New York"
               data-component="body">
    <br>
<p>The name of the city. Must not be greater than 255 characters. Example: <code>New York</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="PATCHapi-v1-cities--city_id-"
               value="#FF5733"
               data-component="body">
    <br>
<p>The color associated with the city. Example: <code>#FF5733</code></p>
        </div>
        </form>

                    <h2 id="cities-DELETEapi-v1-cities--city_id-">Delete city.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint delete city data from DB
response remove the specified city from DB</p>

<span id="example-requests-DELETEapi-v1-cities--city_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/cities/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/cities/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-cities--city_id-">
</span>
<span id="execution-results-DELETEapi-v1-cities--city_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-cities--city_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-cities--city_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-cities--city_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-cities--city_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-cities--city_id-" data-method="DELETE"
      data-path="api/v1/cities/{city_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-cities--city_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-cities--city_id-"
                    onclick="tryItOut('DELETEapi-v1-cities--city_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-cities--city_id-"
                    onclick="cancelTryOut('DELETEapi-v1-cities--city_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-cities--city_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/cities/{city_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-cities--city_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-cities--city_id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-cities--city_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-cities--city_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>city_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="city_id"                data-endpoint="DELETEapi-v1-cities--city_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the city. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="channels">Channels</h1>

    

                                <h2 id="channels-GETapi-v1-channels">Display a listing of the channels.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint display all channels from DB
response get all channels</p>

<span id="example-requests-GETapi-v1-channels">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/channels" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/channels"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-channels">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-channels" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-channels"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-channels"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-channels" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-channels">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-channels" data-method="GET"
      data-path="api/v1/channels"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-channels', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-channels"
                    onclick="tryItOut('GETapi-v1-channels');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-channels"
                    onclick="cancelTryOut('GETapi-v1-channels');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-channels"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/channels</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-channels"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-channels"
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
                              name="Accept"                data-endpoint="GETapi-v1-channels"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-channels"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        </form>

                    <h2 id="channels-POSTapi-v1-channels">create channel.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint create new channel
response new channel</p>

<span id="example-requests-POSTapi-v1-channels">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/channels" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"Social Media\",
    \"color\": \"#3357FF\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/channels"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "Social Media",
    "color": "#3357FF"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-channels">
</span>
<span id="execution-results-POSTapi-v1-channels" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-channels"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-channels"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-channels" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-channels">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-channels" data-method="POST"
      data-path="api/v1/channels"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-channels', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-channels"
                    onclick="tryItOut('POSTapi-v1-channels');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-channels"
                    onclick="cancelTryOut('POSTapi-v1-channels');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-channels"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/channels</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-channels"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-channels"
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
                              name="Accept"                data-endpoint="POSTapi-v1-channels"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-channels"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-channels"
               value="Social Media"
               data-component="body">
    <br>
<p>The name of the channel. Must not be greater than 255 characters. Example: <code>Social Media</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="POSTapi-v1-channels"
               value="#3357FF"
               data-component="body">
    <br>
<p>The color associated with the channel. Example: <code>#3357FF</code></p>
        </div>
        </form>

                    <h2 id="channels-PATCHapi-v1-channels--channel_id-">Update channel.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint update channel data
response updated channel data</p>

<span id="example-requests-PATCHapi-v1-channels--channel_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/channels/16" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"Social Media\",
    \"color\": \"#3357FF\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/channels/16"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "Social Media",
    "color": "#3357FF"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-channels--channel_id-">
</span>
<span id="execution-results-PATCHapi-v1-channels--channel_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-channels--channel_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-channels--channel_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-channels--channel_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-channels--channel_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-channels--channel_id-" data-method="PATCH"
      data-path="api/v1/channels/{channel_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-channels--channel_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-channels--channel_id-"
                    onclick="tryItOut('PATCHapi-v1-channels--channel_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-channels--channel_id-"
                    onclick="cancelTryOut('PATCHapi-v1-channels--channel_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-channels--channel_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/channels/{channel_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-channels--channel_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>channel_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="channel_id"                data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the channel. Example: <code>16</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="Social Media"
               data-component="body">
    <br>
<p>The name of the channel. Must not be greater than 255 characters. Example: <code>Social Media</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>color</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="color"                data-endpoint="PATCHapi-v1-channels--channel_id-"
               value="#3357FF"
               data-component="body">
    <br>
<p>The color associated with the channel. Example: <code>#3357FF</code></p>
        </div>
        </form>

                    <h2 id="channels-DELETEapi-v1-channels--channel_id-">Delete channel.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint delete channel data from DB
response remove the specified channel from DB</p>

<span id="example-requests-DELETEapi-v1-channels--channel_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/channels/16" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/channels/16"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-channels--channel_id-">
</span>
<span id="execution-results-DELETEapi-v1-channels--channel_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-channels--channel_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-channels--channel_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-channels--channel_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-channels--channel_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-channels--channel_id-" data-method="DELETE"
      data-path="api/v1/channels/{channel_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-channels--channel_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-channels--channel_id-"
                    onclick="tryItOut('DELETEapi-v1-channels--channel_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-channels--channel_id-"
                    onclick="cancelTryOut('DELETEapi-v1-channels--channel_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-channels--channel_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/channels/{channel_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-channels--channel_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-channels--channel_id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-channels--channel_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-channels--channel_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>channel_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="channel_id"                data-endpoint="DELETEapi-v1-channels--channel_id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the channel. Example: <code>16</code></p>
            </div>
                    </form>

                <h1 id="stakeholder">Stakeholder</h1>

    

                                <h2 id="stakeholder-GETapi-v1-clients--client_id--stakeholders">Display all Stakeholders.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint display all Stakeholder from DB
response get all Stakeholder</p>

<span id="example-requests-GETapi-v1-clients--client_id--stakeholders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://127.0.0.1:8000/api/v1/clients/1/stakeholders" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-clients--client_id--stakeholders">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: false,
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-clients--client_id--stakeholders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-clients--client_id--stakeholders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-clients--client_id--stakeholders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-clients--client_id--stakeholders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-clients--client_id--stakeholders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-clients--client_id--stakeholders" data-method="GET"
      data-path="api/v1/clients/{client_id}/stakeholders"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-clients--client_id--stakeholders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-clients--client_id--stakeholders"
                    onclick="tryItOut('GETapi-v1-clients--client_id--stakeholders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-clients--client_id--stakeholders"
                    onclick="cancelTryOut('GETapi-v1-clients--client_id--stakeholders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-clients--client_id--stakeholders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/clients/{client_id}/stakeholders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-clients--client_id--stakeholders"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-clients--client_id--stakeholders"
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
                              name="Accept"                data-endpoint="GETapi-v1-clients--client_id--stakeholders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="GETapi-v1-clients--client_id--stakeholders"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="GETapi-v1-clients--client_id--stakeholders"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="stakeholder-POSTapi-v1-clients--client_id--stakeholders">create Stakeholder.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint create new Stakeholder
response new Stakeholder</p>

<span id="example-requests-POSTapi-v1-clients--client_id--stakeholders">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"phone\": \"n\",
    \"role\": \"g\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "phone": "n",
    "role": "g"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-clients--client_id--stakeholders">
</span>
<span id="execution-results-POSTapi-v1-clients--client_id--stakeholders" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-clients--client_id--stakeholders"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-clients--client_id--stakeholders"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-clients--client_id--stakeholders" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-clients--client_id--stakeholders">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-clients--client_id--stakeholders" data-method="POST"
      data-path="api/v1/clients/{client_id}/stakeholders"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-clients--client_id--stakeholders', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-clients--client_id--stakeholders"
                    onclick="tryItOut('POSTapi-v1-clients--client_id--stakeholders');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-clients--client_id--stakeholders"
                    onclick="cancelTryOut('POSTapi-v1-clients--client_id--stakeholders');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-clients--client_id--stakeholders"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/clients/{client_id}/stakeholders</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
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
                              name="Accept"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="n"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>role</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="role"                data-endpoint="POSTapi-v1-clients--client_id--stakeholders"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
        </form>

                    <h2 id="stakeholder-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">Update Stakeholder.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint update Stakeholder data
response updated Stakeholder data</p>

<span id="example-requests-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PATCH \
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}" \
    --data "{
    \"name\": \"b\",
    \"phone\": \"n\",
    \"role\": \"g\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};

let body = {
    "name": "b",
    "phone": "n",
    "role": "g"
};

fetch(url, {
    method: "PATCH",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">
</span>
<span id="execution-results-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-" data-method="PATCH"
      data-path="api/v1/clients/{client_id}/stakeholders/{stakeholder_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    onclick="tryItOut('PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    onclick="cancelTryOut('PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-purple">PATCH</small>
            <b><code>api/v1/clients/{client_id}/stakeholders/{stakeholder_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
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
                              name="Accept"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stakeholder_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="stakeholder_id"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the stakeholder. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="name"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="phone"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="n"
               data-component="body">
    <br>
<p>Must match the regex /^+?[0-9\s-()]{7,20}$/. Must not be greater than 50 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>role</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="role"                data-endpoint="PATCHapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
        </form>

                    <h2 id="stakeholder-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">Delete Stakeholder.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>this endpoint delete Stakeholder data from DB
response remove the specified Stakeholder from DB</p>

<span id="example-requests-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders/1" \
    --header "Authorization: Bearer {ACCESS_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --header "X-Organization-Id: {ORGANIZATION_ID}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://127.0.0.1:8000/api/v1/clients/1/stakeholders/1"
);

const headers = {
    "Authorization": "Bearer {ACCESS_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
    "X-Organization-Id": "{ORGANIZATION_ID}",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">
</span>
<span id="execution-results-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-" data-method="DELETE"
      data-path="api/v1/clients/{client_id}/stakeholders/{stakeholder_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    onclick="tryItOut('DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    onclick="cancelTryOut('DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/clients/{client_id}/stakeholders/{stakeholder_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="Bearer {ACCESS_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {ACCESS_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>X-Organization-Id</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="X-Organization-Id"                data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="{ORGANIZATION_ID}"
               data-component="header">
    <br>
<p>Example: <code>{ORGANIZATION_ID}</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>client_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="client_id"                data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the client. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>stakeholder_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="stakeholder_id"                data-endpoint="DELETEapi-v1-clients--client_id--stakeholders--stakeholder_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the stakeholder. Example: <code>1</code></p>
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
