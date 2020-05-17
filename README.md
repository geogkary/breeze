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
composer require geogkary/breeze
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

#### Handling routing:

Breeze handles your API in a linear manner, making appropriate checks during the request. If your API is configured properly and your version is accessible to the request, Breeze will perform the following actions:

1. Collect POST & GET data accepted by your API
2. Call the `API::init()` method and pass the data
3. Check a) if your API requires `$keys` and b) if the request provides a matching key

##### If the request is ONLY for an endpoint group (ex. v1/info/):

1. If you have a controller file, call `new Info()` with the request data
2. Otherwise call `API::routeInfo()` if the request stops there

##### If the request continues to an endpoint (ex. v1/info/releases/):

3. If there's a controller, call `$controller->routeReleases()`
4. Otherwise call `API::routeInfoReleases()` with the request data

If any of the above actions fail the appropriate checks, Breeze serves an error.

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
