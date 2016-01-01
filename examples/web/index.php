<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Brtriver\Controller\Controller;
use Brtriver\Controller\Templatable;
use Brtriver\Controller\JsonResponse;

require __DIR__ . '/../vendor/autoload.php';

$c = new \Slim\Container;
$c['greet'] = 'Hello ';

$c['view'] = function ($container) {
    $view = new \Slim\Views\Twig( __DIR__ . '/../templates', [
        'cache' => '/tmp'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$app = new \Slim\App($c);

// anonymous function version (default)
$app->get('/hello/{name}', function (Request $request, Response $response, $args) use ($app){
    $response->write($app->getContainer()['greet'] . $args['name']);

    return $response;
});

// anonymous class version
$app->get('/plain/{name}', new class($app) extends Controller {

        public function action($args)
        {
            return $this->render($this->container['greet'] . $args['name']);
        }
});

// with anonymous class and trait
$app->get('/twig/{name}', new class($app) extends Controller {
        use Templatable;

        public function action($args)
        {
            return $this->renderWithT('web.html', ['name' => $args['name']]);
        }
});

$app->get('/json/{name}', new class($app) extends Controller {
	    use JsonResponse;

        public function action($args)
        {
            return $this->renderWithJson(['name' => $args['name']]);
        }
});

$app->run();
