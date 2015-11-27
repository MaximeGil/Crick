<?php

require_once __DIR__.'/bootstrap.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));
$app->register(new PommProject\Silex\ServiceProvider\PommServiceProvider(),
        [
    'pomm.configuration' => [
        'db1' => ['dsn' => 'pgsql://hewrdngzmoezev:79xgD8rrTZzSJkHCbNQCJxrcWM@ec2-54-83-53-120.compute-1.amazonaws.com:5432/d5o0bc1t160bqg'],

    ],

         'pomm.logger.service' => 'monolog', // default
        ]
);

$app->get('/', function () use ($app) {

    $usersdb = $app['pomm']['db1']
    ->getQueryManager()
    ->query('select * from users');

    return $app['twig']->render('hello.twig.html', array('users' => $usersdb));
});

return $app;
