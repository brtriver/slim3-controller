<?php
namespace Brtriver\Controller\Test;

use Brtriver\Controller\Controller;
use Brtriver\Controller\Templatable;
use PHPUnit_Framework_Assert;

class TemplatableTraitTest extends \PHPUnit_Framework_TestCase
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

    public function testControllerRenderWithT()
    {
        $c = new class($this->app) extends Controller {
            use Templatable;
            public function action($args)
            {
                $this->renderWithT('path', ['name' => 'test']);
            }
        };

        $mockTemplateEngine = $this->getMockBuilder('Brtriver\Controller\Test\MockTemplateEngine')
            ->getMock();
        $mockTemplateEngine->expects($this->once())
            ->method('render')
            ->with($this->response, 'path', ['name' => 'test']);

        $this->container->expects($this->once())
            ->method('get')
            ->with('view')
            ->willReturn($mockTemplateEngine);

        $c($this->request, $this->response, []);
    }
}

class MockTemplateEngine
{
    public function render()
    {
    }
}
