Slim3-controller
=================

[![Build Status](https://travis-ci.org/brtriver/slim3-controller.svg)](https://travis-ci.org/brtriver/slim3-controller)

Anonymous controller and trait for Slim3 with PHP7.
We can use anonymous classes in PHP7. So I use anonymous classes instead of anonymous functions. Slim3 now supports PSR-7 interfaces for its Request and Response objects. And Slim3 uses extends objects, and use it in your anonymous functions.

But we use Request and Response object directly, so I try to use anonymous classes to write controller action logic and it is to be readability.
[read more](http://brtriver.hatenablog.com/entries/2016/01/02)

Requirements
------------

* PHP 7.0 or later.
* Slim3

Install
--------

install via composer

```bash
composer require brtriver/slim3-controller
```

Usage
-------

you can read [example code](https://github.com/brtriver/slim3-controller/blob/master/examples/web/index.php).

sample code is blow:

```php
use Brtriver\Controller\Controller;

$app->get('/hello/{name}', new class($app) extends Controller {

        public function action($args)
        {
            return $this->render($this->container['greet'] . $args['name']);
        }
});
```

* Controller class has these methods and class properties.
  * methods:
    * action($args): you should write your controller logic in this method.
    * render($output): helper method to render the $output with 200 status
	* render404($output): helper method to render the $output with 404 status
  * properties:
    * $this->request
    * $this->response
    * $this->app
	* $this->container

If use Template engine (PHP or Twig etc...), a renderWithT method in Templatable trait is available:

```php
use Brtriver\Controller\Controller;
use Brtriver\Controller\Templatable;
$app->get('/hello/{name}', new class($app) extends Controller {
        use Templatable;

        public function action($args)
        {
            return $this->renderWithT('web.html', ['name' => $args['name']]);
        }
});
```

If use JSON response, a renderWithJson method in JsonResponse trait is available:

```php
use Brtriver\Controller\Controller;
use Brtriver\Controller\JsonResponse;
$app->get('/json/{name}', new class($app) extends Controller {
	    use JsonResponse;

        public function action($args)
        {
            return $this->renderWithJson(['name' => $args['name']]);
        }
});
```


License
-------

slim3-controller is licensed under the MIT license.


