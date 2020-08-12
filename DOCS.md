# Breeze PHP - Docs

## How to Use

- [Setting up routing](#setting-up-routing)
- [Serving responses](#serving-responses)
- [Handling requests](#handling-requests)
- [Pre-request actions](#pre-request-actions)
- [Authorisation](#authorisation)
- [Using libraries](#using-libraries)
- [Protecting your subdirectories](#protecting-your-subdirectories)

#### Setting up routing:

Breeze requires URL rewrite. Create an `.htaccess` file in your root directory:

```
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Serving responses

Use `Breeze::respond($response)` to serve your responses. Pass an array/object to the response or a response code as a string (ex "200"). By default, Breeze offers the following pre-coded responses:

```json
"200" : "OK",
"400" : "Bad request - missing required parameter(s)",
"401" : "Bad request - incorrect parameter(s)",
"402" : "Empty response - failed to deliver based on request parameter(s)",
"403" : "Forbidden - unauthorized access",
"404" : "Not found - incorrect endpoint provided",
"500" : "Server - something went wrong"
```

Edit `config.php` to create additional responses.

#### Handling requests

Breeze handles your API in a linear manner, making the necessary checks along the way.

```php

// root
"example.com"
// returns a list of your publicly available versions

// version root
"example.com/v1/"
// returns a list of endpoints per group if the option is enabled on config.php
// otherwise returns '200'

// group of endpoints
"example.com/v1/info-about/"
// A. attempts to create a new Info_about($request, $p1, $p2, $p3, $p4) from your controllers
// B. otherwise calls API::routeInfo_about() with the same arguments, ONLY if the request does not continue to a specific endpoint below
// C. otherwise displays the group's endpoints if the option is enabled on config.php

// endpoint
"example.com/v1/info-about/releases/"
// A. attempts to call the controller's routeReleases() method without any arguments passed
// B. otherwise calls API::routeInfo_aboutReleases($request, $p1, $p2, $p3, $p4)

```

Note how the dash `-` is replaced with an underscore `_`.

Breeze can handle up to 4 parameters in your endpoints, which it then stores as variables:

```php

// $p1, $p2, $p3, $p4
"example.com/v1/info/releases/p1/p2/p3/p4/"

```

By default, these parameters are always set as `null`.

#### Pre-request actions

Breeze will collect POST and GET data accepted by your API through the `API::$data` and `API::$query` arrays and attempt to execute `API::init($request)` for your custom pre-request actions.

The `$request` is set to `null` if there are no POST/GET data provided and/or accepted.

#### Authorisation

Breeze will check if your `API::$keys` array is not empty and attempt to a) locate the key in the request POST or GET data and b) match it to the IP you assigned it to.

If the authorisation fails, Breeze terminates with 403.

#### Using libraries

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory.

#### Protecting your subdirectories

Breeze provides the `endpointer.php` file, which serves a generic 404 response to requests. You can optionally require it in index.php files, to protect your API's subdirectories.
