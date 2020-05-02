# Breeze PHP

Use Breeze to quickly and easily build JSON based APIs with PHP.

Released under the MIT license.

### Required

- mikecao/flight

### Suggested

- catfan/Medoo

## How to Install

### Manual

Download [Breeze](https://github.com/geogkary/breeze/archive/master.zip) OR clone the repo in your root directory:

```cmd
git clone https://github.com/geogkary/breeze.git
```

Download [mikecao/flight](...) OR clone the repo:

```cmd
git clone https://github.com/geogkary/breeze.git
```

Create a subdirectory `versions/` in your project's root directory.

Feel free to download the [boilerplate API version](https://github.com/geogkary/breeze/archive/boilerplate.zip) to get started quickly.

Edit your setup with `config.php`, located in Breeze's root directory.

### Composer

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
