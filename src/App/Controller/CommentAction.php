<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use App\Service\UserService;
use App\Entity\User;

class CommentAction implements ActionInterface
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var User
     */
    protected $user;

    /**
     * @param Twig $view
     * @param UserService $userService
     */
    public function __construct(Twig $view, UserService $userService)
    {
        $this->view = $view;
        $this->user = $userService->getFromSession();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return View
     */
    public function dispatch(Request $request, Response $response)
    {
        return $this->view->render($response, 'comment.html', [
            'email' => $this->user->getEmail(),
        ]);
    }
}
