<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use crick\Security\Provider\UserProvider;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Validator\Constraints as Assert;
use crick\Form\FormRegister; 


$app = new Silex\Application();

/* --------------------------------------------------------------------------- */
// Config

$app['debug'] = true;

/* --------------------------------------------------------------------------- */
// Providers

$app->register(new FormServiceProvider());
$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));


include __DIR__ . '/security.php';

$pomm = require __DIR__ . '/../.pomm_cli_bootstrap.php';
$users = $pomm['db'];

$app['security.api_key.param_name'] = 'api_key';
$app['security.orm.user_provider'] = $app->share(function () use ($app, $users) {
    return new UserProvider($users);
});

/* --------------------------------------------------------------------------- */
// Security Rules

$app['security.access_rules'] = array(
    array('^/api/ping', 'ROLE_USER'),
);
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER'),
);

/* --------------------------------------------------------------------------- */
// Controllers

$app->get('/', 'crick\Controller\PageController::getHelloWorld');

$app->get('/api/ping', 'crick\Controller\ApiController::getPongAction');

$app->match('/register', 'crick\Controller\RegisterController::registerAction');

/* --------------------------------------------------------------------------- */
// Stack (+ content negotiation)

return new Negotiation($app, null, null, null, [
    'format_priorities' => ['html', 'json'],
        ]);
