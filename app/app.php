<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use crick\Security\Provider\UserProvider;

$app = new Silex\Application();

/*---------------------------------------------------------------------------*/
// Config

$app['debug'] = true;

/*---------------------------------------------------------------------------*/
// Providers

$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

include __DIR__ . '/security.php';

$pomm  = require __DIR__ . '/../.pomm_cli_bootstrap.php';
$users = $pomm['db'];

$app['security.api_key.param_name'] = 'api_key';
$app['security.orm.user_provider']  = $app->share(function () use ($app, $users) {
    return new UserProvider($users);
});

$app->register(new \Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => [
        'api' => [
            'pattern'   => '^/api',
            'stateless' => true,
            'api_key'   => true, // Our simple API Key authenticator
            'anonymous' => true,
            'users'     => $app['security.orm.user_provider'],
        ],
    ],
]);

/*---------------------------------------------------------------------------*/
// Controllers

$app->get('/', 'crick\Controller\PageController::getHelloWorld');

$app->get('/register', 'crick\Controller\PageController::getRegisterPage');

$app->get('/api/ping', 'crick\Controller\ApiController::getPongAction');

/*---------------------------------------------------------------------------*/
// Stack (+ content negotiation)

return new Negotiation($app, null, null, null, [
    'format_priorities' => [ 'html', 'json' ]
]);
