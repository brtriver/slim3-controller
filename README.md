Slim3-controller
=================

Anonymous controller and trait for Slim3 with PHP7.

Requirements
------------

* PHP 7.0 or later.
* Slim3

Install
--------

```bash
composer require brtriver/slim3-controller
```

Usage
-------

see below code.

```php
use Brtriver\Controller\Controller;

$app->get('/hello/{name}', new class($app) extends Controller {

        public function action($args)
        {
            return $this->render($this->container['greet'] . $args['name']);
        }
});
```

* Controller class has these methods and variables.
  * methods:
    * action($args): write your controller code.
    * render($output): render the $output with 200 status
	* render404($output): render the $output with 404 status
  * variables.
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


