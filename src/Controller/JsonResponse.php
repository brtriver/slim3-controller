<?php
namespace Brtriver\Controller;

trait  JsonResponse
{
    public function renderWithJson($data, $status = 200, $encodingOptions = 0)
    {
        return $this->response->withJson($data, $status, $encodingOptions);
    }
}
