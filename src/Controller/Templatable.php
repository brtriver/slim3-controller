<?php
namespace Brtriver\Controller;

trait  Templatable
{
    private $templatePath;
    private $cachePath;

    public function renderWithT($path, $args)
    {
        return $this->container->get('view')->render($this->response, $path, $args);
    }
}
