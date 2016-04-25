<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use App\Controller;
use App\Service\UserService;

$file     = dirname(__FILE__) . '/settings.local.php';
$settings = file_exists($file) === true ? require $file : require dirname(__FILE__) . '/settings.production.php';

// Get container
$container = new \Slim\Container($settings);

$container['config_db'] = function ($c) {
    return $c->get('settings')['db'];
};

$container['config_mail'] = function ($c) {
    return $c->get('settings')['mail'];
};

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(dirname(__DIR__).'/src/view/');
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'], $container['request']->getUri()
    ));

    return $view;
};

$container['entity_manager'] = function ($c) {
    $paths     = array(dirname(__DIR__).'/src/App/Entity/');
    $isDevMode = false;

    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
    return EntityManager::create($c['config_db'], $config);
};

$container['mailer_message'] = $container->factory(function ($c) {
    return Swift_Message::newInstance()
            ->addTo(
                $c['config_mail']['from']['email'],
                $c['config_mail']['from']['name']
    );
});

$container['mailer_transport'] = function () {
    return Swift_SendmailTransport::newInstance();
};

$container['mailer_mailer'] = $container->factory(function ($c) {
    return Swift_Mailer::newInstance($c['mailer_transport']);
});

$container['service_user'] = function ($c) {
    return new UserService($c['entity_manager']);
};

$container['action_login'] = function ($c) {
    return new Controller\LoginAction($c['view']);
};

$container['action_login_attempt'] = function ($c) {
    return new Controller\LoginAttemptAction(
        $c['view'],
        $c['service_user']
    );
};

$container['action_comment'] = function ($c) {
    return new Controller\CommentAction(
        $c['view'],
        $c['service_user']
    );
};

$container['action_comment_create'] = function ($c) {
    return new Controller\CommentCreateAction(
        $c['view'],
        $c['mailer_message'],
        $c['mailer_mailer'],
        $c['service_user']
    );
};
