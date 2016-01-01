<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use crick\Security\Provider\UserProvider;
use Silex\Provider\FormServiceProvider;

$app = new Silex\Application();

/* --------------------------------------------------------------------------- */
// Config

 $app['debug'] = true;

/* --------------------------------------------------------------------------- */
// Providers
$app->register(new FormServiceProvider());
$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
 $app['session.test'] = true;
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => 'logs/log.log',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.domains' => array(),
));

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/../views',
]);

include __DIR__ . '/security.php';

$pomm = require __DIR__ . '/../.pomm_cli_bootstrap.php';
$query = $pomm['db'];

$app['security.api_key.param_name'] = 'api_key';
$app['security.orm.user_provider'] = $app->share(function () use ($app, $query) {
    return new UserProvider($query);
});
$app['db'] = $app->share(function () use ($app, $query) {
    return $query;
});

$app->register(new \Silex\Provider\SecurityServiceProvider(), [
    'security.firewalls' => [
        'api' => [
            'pattern' => '^/api',
            'anonymous' => true,
            'api_key' => true, // Our simple API Key authenticator
            'users' => $app['security.orm.user_provider'],
        ],
        'site' => [
            'pattern' => '^.*$(?<!api)',
            'anonymous' => true,
            'form' => array('login_path' => '/login', 'check_path' => 'login_check'),
            'logout' => array('logout_path' => '/logout'),
            'users' => $app['security.orm.user_provider'],
        ],
    ],
]);

/* --------------------------------------------------------------------------- */
// Security Rules

$app['security.access_rules'] = array(
    array('^/api/ping', 'ROLE_USER'),
    array('^/api/frames/bulk', 'ROLE_USER'),
);
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER'),
);

/* --------------------------------------------------------------------------- */
// Controllers
$app->get('/', 'crick\Controller\PageController::getHelloWorld');

$app->get('/api/ping', 'crick\Controller\ApiController::getPongAction');
$app->get('/api/projects', 'crick\Controller\ApiController::getProjects');
$app->post('api/frames/bulk', 'crick\Controller\ApiController::postFrame');

$app->match('/register', 'crick\Controller\RegisterController::registerAction');

$app->get('/login', 'crick\Controller\PageController::getLogin');

$app->match('/projects', 'crick\Controller\ProjectController::getOrCreateProjects');
$app->get('/projects/{id}', 'crick\Controller\ProjectController::getProjectById');

$app->get('/profil', 'crick\Controller\ProfilController::getProfil');


/* --------------------------------------------------------------------------- */
// Stack (+ content negotiation)

return new Negotiation($app, null, null, null, [
    'format_priorities' => ['html', 'json'],
        ]);
