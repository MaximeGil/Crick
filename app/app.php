<?php

require_once __DIR__.'/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
$app->register(new PommProject\Silex\ServiceProvider\PommServiceProvider(), [
    'pomm.configuration' => [
        'db1' => ['dsn' => 'pgsql://user:pass@host:port/dbname'],
    ],
    'pomm.logger.service' => 'monolog',
        ]
);

$app
        ->get('/', 'crick\Controller\ApiController::getPong');

$app
        ->get('/api/ping', 'crick\Controller\ApiController::getPong');

return $app = new Negotiation($app, null, null, null, ['format_priorities' => ['html', 'json']]);
