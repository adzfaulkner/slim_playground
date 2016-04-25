<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use \App\Service\UserService;

class LoginAttemptAction implements ActionInterface
{
    /**
     * @var Twig
     */
    protected $view;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param Twig $view
     * @param UserService $userService
     */
    public function __construct(Twig $view, UserService $userService)
    {
        $this->view = $view;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return View
     */
    public function dispatch(Request $request, Response $response)
    {
        $postVars = $request->getParsedBody();

        $user = $this->userService->getUsingEmailAndPassword(
            $postVars['email'],
            $postVars['password']
        );

        if (empty($user) === true) {
            return $this->view->render($response, 'index.html', [
                'error' => true,
                'message' => 'We were unable to authenticate you. Please try again.'
            ]);
        }

        $this->userService
            ->sessionize($user);

        return $response->withStatus(302)
            ->withHeader('Location', '/comment');
    }
}
