<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use Symfony\Component\HttpFoundation\RequestMatcher;

$app = new Silex\Application();
$app['debug'] = true;


$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));


$pomm = require __DIR__ . "/../.pomm_cli_bootstrap.php";
$users = $pomm['db']
        ->getModel('db\Db\PublicSchema\UsersModel')
        ->findAll()
;

$app
        ->get('/', 'crick\Controller\ApiController::getPong');


$app
        ->get('/api/ping', 'crick\Controller\ApiController::getPong');

return $app = new Negotiation($app, null, null, null, ['format_priorities' => ['html', 'json']]);
