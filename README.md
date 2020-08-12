# Breeze PHP

Use Breeze to quickly setup and start building JSON APIs with PHP. Breeze is a lightweight framework that takes care of versioning and routing, built on top of [mikecao/flight](https://github.com/mikecao/flight).

Requires PHP 5.6 or greater.

- [Install](#how-to-install)
- [Get Started](#how-to-start)
- [How to Use](https://github.com/geogkary/breeze/blob/master/DOCS.md)

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
composer require geogkary/breeze v1.0.4-beta
```

```PHP
// autoload
require 'vendor/autoload.php';

// manually
require 'vendor/geogkary/breeze/engine/composer.php';
```

## How to Start

1. Create a subdirectory `versions/` in your project's root directory.
2. Download the [boilerplate API version](https://github.com/geogkary/breeze/archive/boilerplate.zip) to get started.
3. Edit `config.php` located in Breeze's root directory.
4. View the [docs](https://github.com/geogkary/breeze/blob/master/DOCS.md) to understand Breeze in 5 minutes.

## Thanks

- [Mike Cao](https://github.com/mikecao) for the Flight framework
- [GitHub API](https://developer.github.com/v3/) for the immense inspiration on structuring RESTful APIs
- [Valandis Zotos](https://github.com/BalzoT) for his invaluable feedback and help
- [Angel Lai](https://github.com/catfan) for the Medoo framework
- [Dongsheng Cai](https://github.com/dcai) for the curl library
- [Kaldi](https://en.wikipedia.org/wiki/Coffee) (or the goats?) for discovering coffee
