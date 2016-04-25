<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../bootstrap.php';

session_start();

$app = new \Slim\App($container);

$app->add(function (Request $request, Response $response, $next) {

    if ($request->getUri()->getPath() !== '/' && empty($_SESSION['user']) === true) {
        return $response->withStatus(401)
            ->withHeader('Location', '/');
    }

    $response = $next($request, $response);
    return $response;
});

$app->get('/', 'action_login:dispatch');

$app->post('/', 'action_login_attempt:dispatch');

$app->get('/comment', 'action_comment:dispatch');

$app->post('/comment', 'action_comment_create:dispatch');

$app->run();
