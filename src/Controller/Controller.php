<?php
namespace Brtriver\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    protected $app;
    protected $container;
    protected $request;
    protected $response;

    public function __construct($app)
    {
        $this->app = $app;
        $this->container = $app->getContainer();
    }

    public abstract function action($args);

    public function __invoke(Request $request,  Response $response, $args)
    {
        $this->request = $request;
        $this->response = $response;
        return $this->action($args);
    }

    public function render($output)
    {
        return $this->response->write($output);
    }

    public function render404($output)
    {
        return $this->response->withStatus(404)->write($output);
    }

}
