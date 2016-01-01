<?php
namespace Brtriver\Controller\Test;

use Brtriver\Controller\Controller;
use PHPUnit_Framework_Assert;

class ControllerTest extends \PHPUnit_Framework_TestCase
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

    public function testControllerAction()
    {
        $c = new class($this->app) extends Controller {
                public function action($args)
                {
                    PHPUnit_Framework_Assert::assertSame(['name' => 'test'], $args);
                    PHPUnit_Framework_Assert::assertInstanceOf('Slim\App', $this->app);
                    PHPUnit_Framework_Assert::assertInstanceOf('Psr\Http\Message\ServerRequestInterface', $this->request);
                    PHPUnit_Framework_Assert::assertInstanceOf('Psr\Http\Message\ResponseInterface', $this->response);
                    PHPUnit_Framework_Assert::assertInstanceOf('Interop\Container\ContainerInterface', $this->container);
                }
            };

        $c($this->request, $this->response, ['name' => 'test']);

    }

    public function testControllerRender()
    {
        $c = new class($this->app) extends Controller {
            public function action($args)
            {
                $this->render('test');
            }
        };

        $c($this->request, $this->response, []);
    }

    public function testControllerRender404()
    {
        $c = new class($this->app) extends Controller {
            public function action($args)
            {
                $this->render404('test');
            }
        };

        $this->response->expects($this->once())
            ->method('withStatus')
            ->with('404')
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('write')
            ->with('test');

        $c($this->request, $this->response, []);
    }
}
