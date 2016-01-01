<?php
namespace Brtriver\Controller\Test;

use Brtriver\Controller\Controller;
use Brtriver\Controller\JsonResponse;
use PHPUnit_Framework_Assert;

class JsonResponseTraitTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->request = $this->getMockBuilder('Psr\Http\Message\ServerRequestInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->response = $this->getMockBuilder('Slim\Http\Response')
            ->disableOriginalConstructor()
            ->getMock();
        $this->container = $this->getMockBuilder('Interop\Container\ContainerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $this->app = $this->getMockBuilder('Slim\App')->getMock();
        $this->app->method('getContainer')
            ->willReturn($this->container);
    }

    private function getEmptyControllerClass()
    {
    }

    public function testControllerRenderWithJson()
    {
        $c = new class($this->app) extends Controller {
            use JsonResponse;
            public function action($args)
            {
                $this->renderWithJson('data', 200, 1);
            }
        };

        $this->response->expects($this->once())
            ->method('withJson')
            ->with('data', 200, 1);

        $c($this->request, $this->response, []);
    }
}
