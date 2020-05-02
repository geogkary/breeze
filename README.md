# Breeze PHP

Use Breeze to quickly and easily build JSON based APIs with PHP.

Released under the MIT license.

### Required

- mikecao/flight

### Suggested

- catfan/Medoo

## How to Install

### Manual

Download [Breeze](https://github.com/geogkary/breeze/archive/master.zip) or clone this repo:

```cmd
git clone https://github.com/geogkary/breeze.git
```

1. Download Breeze and unzip in your root directory
2. Download Flight and unzip inside `breeze/libraries/`
3. Download Medoo and unzip inside `breeze/libraries/`
4. Setup your version folders inside `versions/`

### Composer

## How to Configure

View the [docs](https://breezephp.com/docs) for more details.

#### Getting started:

- Edit your setup with `config.php`, located in Breeze's root directory
- Feel free to download the [boilerplate API version](https://github.com/geogkary/breeze/archive/boilerplate.zip) to get started quickly

#### Using libraries:

If you're not using Composer, you can optionally load more libraries in the `engine/libraries/` directory. By default, Breeze autoloads PHP classes located in that directory.

Use subdirectories if you don't want that behavior (ex. `libraries/db/Medoo.php`).

#### Protecting your subdirectories:

Breeze provides the `engine/endpointer.php` file, which serves a generic 404 response to requests. You can optionally require that file to protect your API's subdirectories.

- Create an `index.php` file
- Require `{PATH_TO}/engine/endpointer.php`

## How to Contribute
