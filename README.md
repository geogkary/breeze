# Breeze PHP

Use Breeze to quickly setup and start building JSON APIs with PHP. Breeze is a lightweight framework that takes care of versioning and routing, built on top of [mikecao/flight](https://github.com/mikecao/flight).

Requires PHP 5.6 or greater.

- [Install](#how-to-install)
- [Start](#how-to-start)
- [Config](#how-to-configure)

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

## How to Configure

View the [docs](https://breezephp.com/docs) for more details.

#### Setting up routing:

Breeze is built on top of [Flight](https://github.com/mikecao/flight), which requires URL rewriting. Here's a quick .htaccess to copy:

```
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Serving responses:

Use `Breeze::respond($data = array());` to serve your responses. If your array is not empty, Breeze will default to a 200 response with the data, in nicely-tailored JSON format.

By default, Breeze offers the following pre-coded responses:

```json
"200" : "OK",
"400" : "Bad request - missing required parameter(s)",
"401" : "Bad request - incorrect parameter(s)",
"402" : "Empty response - failed to deliver based on request parameter(s)",
"403" : "Forbidden - unauthorized access",
"404" : "Not found - incorrect endpoint provided",
"500" : "Server - something went wrong"
```

You can edit the messages in `config.php`, but make sure you don't remove the codes, otherwise Breeze will fail to deliver an appropriate response (ex. when authorizing).

#### Handling requests:

Breeze handles your API in a linear manner, making the necessary checks along the way.

If your API is configured properly and your version is accessible to the request through `config.php`, Breeze will perform the following actions:

##### 1. Prepare the request

Breeze will collect POST and GET data accepted by your API through the `API::$data` and `API::$query` arrays and attempt to execute `API::init($request = array())` so you can perform custom pre-request actions.

##### 2. Authorise the request

Breeze will check if your `API::$keys` array is not empty and attempt to a) locate the key in the request POST or GET data and b) match it to the IP you can have configure it for.

If the authorisation fails, Breeze terminates with 403.

##### 3. Handle the endpoint group

If the request is for an endpoint group (ex. myapi.com/v1/info/), Breeze will attempt to create a `new Info()` by loading your controller `Info.php`.

Otherwise, if the request stops there, attempt to call `API::routeInfo()`.

##### 4. Handle the endpoint call

If the request continues to an endpoint (ex. v1/info/releases/):

3. If there's a controller, call `$controller->routeReleases()`
4. Otherwise call `API::routeInfoReleases()` with the request data

If any of the above actions fail the appropriate checks, Breeze responds with the corresponding error status and message (ex. 403 Forbidden, 402 Empty Response, etc).

Breeze replaces slashes `-` with an underscore `_` (ex. v1/api-info/ => routeApi_info).

#### Using libraries:

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory.

#### Protecting your subdirectories:

Breeze provides the `endpointer.php` file, which serves a generic 404 response to requests. You can optionally require it in index.php files, to protect your API's subdirectories.

## Thanks

- [Mike Cao](https://github.com/mikecao) for the Flight framework
- [GitHub API](https://developer.github.com/v3/) for the immense inspiration on structuring RESTful APIs
- [Valandis Zotos](https://github.com/BalzoT) for his invaluable feedback and help
- [Angel Lai](https://github.com/catfan) for the Medoo framework
- [Dongsheng Cai](https://github.com/dcai) for the curl library
- [Kaldi](https://en.wikipedia.org/wiki/Coffee) (or the goats?) for discovering coffee

Create static websites with the [Webmart](https://github.com/geogkary/webmart) framework for PHP.
