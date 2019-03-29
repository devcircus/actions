# Bright Components - Actions
### Invokable actions. Not controllers.

[![Latest Stable Version](https://poser.pugx.org/bright-components/actions/v/stable)](https://packagist.org/packages/bright-components/actions)
[![Build Status](https://img.shields.io/travis/bright-components/actions/master.svg)](https://travis-ci.org/bright-components/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/bright-components/actions.svg)](https://scrutinizer-ci.com/g/bright-components/actions)
[![Total Downloads](https://poser.pugx.org/bright-components/actions/downloads)](https://packagist.org/packages/bright-components/actions)

![Bright Components](https://s3.us-east-2.amazonaws.com/bright-components/bc_large.png "Bright Components")

### Disclaimer
The packages under the BrightComponents namespace are basically a way for me to avoid copy/pasting simple functionality that I like in all of my projects. There's nothing groundbreaking here, just a little extra functionality for form requests, controllers, custom rules, services, etc.

Invokable actions are a clean, slim alternative to classic MVC controllers. The general idea is based on the "A" in [ADR - Action Domain Responder](http://paul-m-jones.com/archives/5970), by [Paul M. Jones](https://twitter.com/pmjones).

For example, instead of a CommentController, with the usual methods like "Create", "Store", "Show", "Edit", etc, we'll create "actions" that have a single responsibility. Dependencies can be injected via the constructor, or on the action method itself. By default, we'll use the magic "__invoke" method, however, this can be customized:
```php
namespace App\Http\Controllers;

use App\MyDatasource;
use Illuminate\Http\Request;
use App\Http\Actions\Action;
use App\Http\Responders\Post\IndexResponder;

class PostIndex implements Action
{
    /**
     * The Responder.
     *
     * @var \App\Http\Responders\Post\IndexResponder
     */
    private $responder;

    /**
     * Construct a new PostIndex Controller.
     *
     * @param \App\Http\Responders\Post\IndexResponder $responder
     */
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $data = MyDatasource::getSomeData($request);

        return $this->responder->respond($request, $data);
    }
}
```

One benefit over the traditional MVC style controllers, is the clarity it brings, the narrow class responsibility, fewer dependencies, and overall organization. When used together with [responders](https://github.com/bright-components/responders), you can really clean up your 'controllers' and bring a lot of clarity to your codebase.

## Installation
You can install the package via composer. From your project directory, in your terminal, enter:
```bash
composer require bright-components/actions
```
> Note: Until version 1.0 is released, major features and bug fixes may be added between minor versions. To maintain stability, I recommend a restraint in the form of "0.1.*". This would take the form of:
```bash
composer require "bright-components/actions:0.1.*"
```

In Laravel > 5.6.0, the ServiceProvider will be automtically detected and registered.
If you are using an older version of Laravel, add the package service provider to your config/app.php file, in the 'providers' array:
```php
'providers' => [
    //...
    BrightComponents\Actions\ActionServiceProvider::class,
    //...
];
```

Then, run:
```bash
php artisan vendor:publish
```
and choose the BrightComponents/Actions option.

This will copy the package configuration (actions.php) to your 'config' folder.
See below for all configuration options:

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Namespace
    |--------------------------------------------------------------------------
    |
    | Set the namespace for the Actionss.
    |
    */
    'namespace' => 'Http\\Actions',

    /*
    |--------------------------------------------------------------------------
    | Method name
    |--------------------------------------------------------------------------
    |
    | Set the name for the mothod to be invoked in your actions.
    |
    */
    'method' => '__invoke',

    /*
    |--------------------------------------------------------------------------
    | Duplicate Suffixes
    |--------------------------------------------------------------------------
    |
    | If you have a Action suffix set in the config and try to generate a Action that also includes the suffix,
    | the package will recognize this duplication and rename the Action to remove the extra suffix.
    | This is the default behavior. To override and allow the duplication, change to false.
    |
    */
    'override_duplicate_suffix' => true,
];
```

## Usage
To begin using BrightComponents/Actions, simply follow the instructions above, then generate your Action classes as needed.
To generate an PostIndex action, as in the example above, enter the following command into your terminal:
```bash
php artisan adr:action Posts\\PostIndex
```

Place your logic inside the "__invoke" method (or the method name you chose in the configuration file).
> Note: When utilizing the __invoke magic method for your action, you'll need to be sure the action class exists before definng the route, if not, you will receive an 'invalid route' exception. Routes for invokable classes can be defined as follows:
```php
Route::get('comments', \App\Http\Actions\Comments\CommentIndex::class);
```

Alternatively, you can import the Action namespace at the top of the routes file, then use the short name for the class in the route definition:
```php
<?php

use App\Http\Actions\Comments\CommentIndex;

Route::get('comments', CommentIndex::class);
```

> Important: By default, we use the magic "__invoke" method when generating the Action class. When using __invoke, you can define your routes as above. If you choose to change the method in the configuration, you will need to define your routes in the more traditional manner. For example, if you choose "run" as your method name:
```php
Route::get('comments', 'App\Http\Actions\Comments\CommentIndex@run');
```
or
```php
Route::get('comments', \App\Http\Actions\Comments\CommentIndex::class.'@run');
```

> Also, if you're using the package default namespace for actions, you'll need to be sure that the namespace in your RouteServiceProvider has been updated or set to an emnpty string if you're using the fully qualified namespace of the action class.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email clay@phpstage.com instead of using the issue tracker.

## Roadmap

We plan to work on flexibility/configuration soon, as well as release a framework agnostic version of the package.

## Credits

- [Clayton Stone](https://github.com/devcircus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
