# Breeze PHP

Use Breeze to quickly setup and start building JSON APIs with PHP. Breeze is a lightweight framework that takes care of versioning and routing, built on top of [mikecao/flight](https://github.com/mikecao/flight).

Requires PHP 5.6 or greater.

- [Install](#how-to-install)
- [Get Started](#how-to-start)
- [Configuration & Usage](#how-to-use)

Released under the [MIT License](https://github.com/geogkary/breeze/LICENSE.md).

## How to Install

See available versions on [GitHub](https://github.com/geogkary/breeze/releases) / [Packagist](https://packagist.org/packages/geogkary/breeze).

### Manually

Download [Breeze](https://github.com/geogkary/breeze/archive/master.zip) OR clone the repo in your project's root directory:

```cmd
git clone https://github.com/geogkary/breeze.git
```

Download [Flight](https://github.com/mikecao/flight/archive/master.zip) OR clone the repo inside `engine/flight/`:

```cmd
cd engine/flight/
git clone https://github.com/mikecao/flight.git
```

Run Breeze:

```PHP
require 'engine/Breeze.php';
Breeze::init();
```

### Composer

Require and load the package:

```cmd
composer require geogkary/breeze v1.0.3-beta
```

```PHP
// autoload
require 'vendor/autoload.php';

// manually
require 'vendor/geogkary/breeze/engine/composer.php';
```

## How to Start

1. Create a subdirectory `versions/` in your project's root directory
2. Download the [boilerplate API version](https://github.com/geogkary/breeze/archive/boilerplate.zip) to get started quickly
3. Edit `config.php` located in Breeze's root directory

## How to Use

View the [docs](https://breezephp.com/docs) for more details.

#### Setting up routing:

Create an `.htaccess` file in your root directory:

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
// returns a list of endpoints per group if option is enabled on config.php
// otherwise returns '200'

// group of endpoints
"example.com/v1/info-about/"
// A. attempts to create a new Info_about($request, $p1, $p2, $p3, $p4) from your controllers
// B. otherwise calls API::routeInfo_about() with the same arguments, ONLY if the request does not continue to a specific endpoint below

// endpoint
"example.com/v1/info-about/releases/"
// A. attempt to call the controller's routeReleases() method (with no arguments)
// B. otherwise call API::routeInfo_aboutReleases($request, $p1, $p2, $p3, $p4)

```

Note how Breeze replaces the dash `-` with an underscore `_`.

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

## Thanks

- [Mike Cao](https://github.com/mikecao) for the Flight framework
- [GitHub API](https://developer.github.com/v3/) for the immense inspiration on structuring RESTful APIs
- [Valandis Zotos](https://github.com/BalzoT) for his invaluable feedback and help
- [Angel Lai](https://github.com/catfan) for the Medoo framework
- [Dongsheng Cai](https://github.com/dcai) for the curl library
- [Kaldi](https://en.wikipedia.org/wiki/Coffee) (or the goats?) for discovering coffee

Create static websites with the [Webmart](https://github.com/geogkary/webmart) framework for PHP.
