# Breeze PHP

Use Breeze to quickly and easily build JSON APIs with PHP.

Requires PHP 5.5 or greater.

- [Install](https://github.com/geogkary/breeze/tree/dev#how-to-install)
- [Start](https://github.com/geogkary/breeze/tree/dev#how-to-start)
- [Docs](https://github.com/geogkary/breeze/tree/dev#how-to-configure)

Released under the [MIT License](https://github.com/geogkary/breeze/blob/dev/LICENSE.md).

## How to Install

See available versions on [GitHub](...) / [Packagist](...).

### Manually

Download [Breeze](https://github.com/geogkary/breeze/archive/master.zip) OR clone the repo in your project's root directory:

```cmd
git clone https://github.com/geogkary/breeze.git
```

Download [Flight](...) OR clone the repo inside `engine/flight/`:

```cmd
cd engine/flight/
git clone https://github.com/mikecao/flight.git
```

Run Breeze:

```php
require 'engine/Breeze.php';
Breeze::init();
```

### Composer

Require and load the package:

```cmd
composer require geogkary/breeze
```

```php
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

Breeze is built on top of Flight, which requires URL rewriting. Here's a quick .htaccess to copy:

```
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

#### Using libraries:

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory. By default, Breeze autoloads PHP classes located in that directory.

Use subdirectories or edit Breeze's `config.php` file.

#### Protecting your subdirectories:

Breeze provides the `engine/endpointer.php` file, which serves a generic 404 response to requests. You can optionally require that file to protect your API's subdirectories.

## Thanks

- [Mike Cao](https://github.com/mikecao) for the Flight framework
- [GitHub API](https://developer.github.com/v3/) for the immense inspiration on structuring RESTful APIs
- [Valandis Zotos](https://github.com/BalzoT) for his invaluable feedback and help
- [Angel Lai](https://github.com/catfan) for the Medoo framework
- [Dongsheng Cai](https://github.com/dcai) for the curl library
- [Kaldi](https://en.wikipedia.org/wiki/Coffee) (or the goats?) for discovering coffee

Create static websites with the [Webmart](https://github.com/geogkary/webmart) framework for PHP.
