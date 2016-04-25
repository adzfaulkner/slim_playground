<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use App\Entity\User;
use Swift_Message;
use Swift_Mailer;
use Exception;
use App\Service\UserService;

class CommentCreateAction implements ActionInterface
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
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Swift_Message
     */
    protected $message;

    /**
     * @param Twig $view
     * @param Swift_Message $message
     * @param Swift_Mailer $mailer
     * @param UserService $userService
     */
    public function __construct(
        Twig $view,
        Swift_Message $message,
        Swift_Mailer $mailer,
        UserService $userService
    )
    {
        $this->view = $view;
        $this->user = $userService->getFromSession();
        $this->message = $message;
        $this->mailer = $mailer;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return View
     */
    public function dispatch(Request $request, Response $response)
    {
        $user = $this->user;
        $postVars = $request->getParsedBody();

        try {
            $message = $this->message
                ->setTo($user->getEmail())
                ->setSubject($postVars['subject'])
                ->setBody($postVars['comments']);

            if ($this->mailer
                ->send($message)) {
                return $this->generateView(
                    $response,
                    true,
                    'Thank you for your comment! We will be in touch.'
                );
            } else {
                throw new Exception();
            }
        } catch (Exception $ex) {
            return $this->generateView(
                $response,
                false,
                'Unfortunately our system were unable to send the communication. Please contact support.');
        }
    }

    /**
     * Helper method to generate a view object using the args
     * 
     * @param Response $response
     * @param type $success
     * @param type $message
     * @param type $errors
     * @return type
     */
    public function generateView(Response $response, $success, $message = '', $errors = [])
    {
        return $this->view->render($response, 'comment.html', [
            'email' => $this->user->getEmail(),
            'success' => $success,
            'message' => $message,
            'errors' => $errors,
        ]);
    }
}
