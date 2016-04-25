<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

interface ActionInterface
{
    /**
     * Main invokable method that is executed
     *
     * @param \App\Controller\Request $request
     * @param \App\Controller\Response $response
     * @return mixed
     */
    public function dispatch(Request $request, Response $response);
}

