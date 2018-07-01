# Bright Components - Actions
### Invokable actions. Not controllers.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bright-components/actions.svg)](https://packagist.org/packages/bright-components/actions)
[![Build Status](https://img.shields.io/travis/bright-components/actions/master.svg)](https://travis-ci.org/bright-components/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/bright-components/actions.svg)](https://scrutinizer-ci.com/g/bright-components/actions)
[![Total Downloads](https://img.shields.io/packagist/dt/bright-components/actions.svg)](https://packagist.org/packages/bright-components/actions)

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

You can install the package via composer:

```bash
composer require bright-components/actions
```
Laravel versions > 5.6.0 will automatically identify and register the service provider.

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

    'method' => '__invoke'
];
```

## Usage

To begin using BrightComponents/Actions, simply follow the instructions above, then generate your Action classes as needed.
To generate an PostIndex action, as in the example above, enter the following command into your terminal:

```bash
php artisan make:action Posts\\PostIndex
```
Place your logic inside the "__invoke" method (or the method name you chose in the configuration file).
> Note: When utilizing the __invoke magic method for your action, you'll need to be sure the action class exists before definng the route, if not, you will receive an 'invalid route' exception. Routes for invokable classes can be defined as follows:
```php
Route::get('comments', App\Http\Actions\Comments\CommentIndex::class);
// or import the class at the top of the file and use the short name.
```
> Also, if you're using the package default namespace for actions, you'll need to be sure that the namespace in your RouteServiceProvider has been updated or set to an emnpty string if you're using the fully qualified namespace of the action class.
```php
public function __invoke(Request $request)
{
    $data = MyDatasource::getSomeData();

    return $this->responder->respond($request, $data)
}
```

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
