<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Negotiation\Stack\Negotiation;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));
$app->register(new PommProject\Silex\ServiceProvider\PommServiceProvider(), 
        [
    'pomm.configuration' =>
    [
        'db1' => ['dsn' => 'pgsql://user:pass@host:port/dbname'],
       
    ],
    
         'pomm.logger.service' => 'monolog', 
        ]
);



$app->get('/', function() use ($app) {

        
    $usersdb = $app['pomm']['db1']
    ->getQueryManager()
    ->query('select * from users');
    
    return $app['twig']->render('hello.twig.html', array('users' => $usersdb) ); 
});


$app
        ->get('/api/ping', 'crick\Controller\ApiController::getPong');



return $app = new Negotiation($app, null, null, null, ['format_priorities' => ['html', 'json']]);
