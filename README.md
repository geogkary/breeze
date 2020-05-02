# Breeze PHP

Use Breeze to quickly and easily build JSON based APIs with PHP.

Released under the MIT license.

### Required

- mikecao/flight

### Suggested

- catfan/Medoo

## How to Install

### Manual

1. Download Breeze and unzip in your root directory
2. Download Flight and unzip inside `breeze/libraries/`
3. Download Medoo and unzip inside `breeze/libraries/`
4. Setup your version folders inside `versions/`

### Composer

## How to Configure

View the [docs](https://breezephp.com/docs) for more details.

#### A few things to consider:

- Edit your setup with `config.php`, located in Breeze's root directory
- Feel free to download the [boilerplate](https://github.com/geogkary/breeze/archive/boilerplate.zip) API version to get started

#### Loading libraries:

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory. By default, Breeze autoloads PHP classes located in the directory. Use subdirectories if you don't want that behavior (ex. `libraries/db/Medoo.php`).

#### Protecting your subdirectories:

Breeze provides an `unrouter.php` file which allows you to respond to requests for subdirectories in a more API like manner, disabling access to your subdirectories.

## How to Contribute
