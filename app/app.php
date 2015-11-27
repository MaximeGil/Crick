<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use Symfony\Component\HttpFoundation\RequestMatcher;
use crick\Security\Provider\UserProvider;
use PommProject\ModelManager\Session;
use crick\Security\Api\ApiKeyAuthentificator;

$app = new Silex\Application();
$app['debug'] = true;


$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));
$app->register(new Silex\Provider\SecurityServiceProvider());

$pomm = require __DIR__ . "/../.pomm_cli_bootstrap.php";
$users = $pomm['db'];

$app['security.firewalls'] = array(
    'api' => array(
        'pattern' => '^/api',
        'security' => $app['debug'] ? false : true,
        'users' => $app->share(function () use ($app) {
                    return new UserProvider($users);
                }),
    ),
);
                
$app
        ->get('/api', 'crick\Security\Api\ApiKeyAuthentificator::createToken');

$app
        ->get('/', 'crick\Controller\ApiController::getPong');


$app
        ->get('/api/ping', 'crick\Controller\ApiController::getPong');

return $app = new Negotiation($app, null, null, null, ['format_priorities' => ['html', 'json']]);
