# Breeze PHP

Use Breeze to quickly and easily build JSON based APIs with PHP.

Requires PHP 5.5 or greater.

- [Install](https://github.com/geogkary/breeze/tree/dev#how-to-install)
- [Start](https://github.com/geogkary/breeze/tree/dev#how-to-start)
- [Configure](https://github.com/geogkary/breeze/tree/dev#how-to-configure)
- [Contribute](https://github.com/geogkary/breeze/tree/dev#how-to-contribute)

Released under the [MIT license](https://github.com/geogkary/breeze/blob/dev/LICENSE.md).

## How to Install

See available versions on [GitHub](...) / [Packagist](...).

### Manually

Download [Breeze](https://github.com/geogkary/breeze/archive/master.zip) OR clone the repo in your project's root directory:

```cmd
git clone https://github.com/geogkary/breeze.git
```

Download [Flight](...) OR clone the repo inside `engine/libraries/`:

```cmd
cd engine/libraries/
git clone https://github.com/mikecao/flight.git
```

Run Breeze in your root `index.php` file:

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

Make sure you have an .htaccess file in your root directory:

```
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

- Create a subdirectory `versions/` in your project's root directory
- Download the [boilerplate API version](https://github.com/geogkary/breeze/archive/boilerplate.zip) to get started quickly
- Edit `config.php` located in Breeze's root directory

## How to Configure

View the [docs](https://breezephp.com/docs) for more details.

#### Using libraries:

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory. By default, Breeze autoloads PHP classes located in that directory.

Use subdirectories if you don't want that behavior (ex. `libraries/db/Medoo.php`).

#### Protecting your subdirectories:

Breeze provides the `engine/endpointer.php` file, which serves a generic 404 response to requests. You can optionally require that file to protect your API's subdirectories.

- Create an `index.php` file
- Require `{PATH_TO}/engine/endpointer.php`

## How to Contribute
