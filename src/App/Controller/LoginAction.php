<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class LoginAction implements ActionInterface
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @param Twig $view
     */
    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return View
     */
    public function dispatch(Request $request, Response $response)
    {
        return $this->view->render($response, 'index.html');
    }
}
