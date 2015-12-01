<?php

require_once __DIR__ . '/bootstrap.php';

use KPhoen\Provider\NegotiationServiceProvider;
use Negotiation\Stack\Negotiation;
use Symfony\Component\HttpFoundation\RequestMatcher;
use PommProject\ModelManager\Session;
use crick\Security\Provider\UserProvider;
use crick\Security\Api\ApiKeyAuthentificator;

$app = new Silex\Application();
$app['debug'] = true;


$app->register(new NegotiationServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views'));

$pomm = require __DIR__ . "/../.pomm_cli_bootstrap.php";
$users = $pomm['db'];

$app['security.authentication_listener.pre_auth.factory'] = $app->protect(function ($type) use ($app) {
    return $app->protect(function ($name, $options) use ($app, $type) {

                $app['security.authentication_listener.' . $name . '.' . $type] = $app->share(function () use ($app, $name, $options, $type) {
                    return new SimplePreAuthenticationListener(
                            $app['security'], $app['security.authentication_manager'], $name, $app['security.' . $type . '.authenticator'], $app['logger']
                    );
                });

                $app['security.authentication_provider.' . $name . '.' . $type] = $app->share(function () use ($app, $name, $type) {
                    return new SimpleAuthenticationProvider(
                            $app['security.' . $type . '.authenticator'], $app['security.user_provider.' . $name], $name
                    );
                });

                return array(
                    'security.authentication_provider.' . $name . '.' . $type,
                    'security.authentication_listener.' . $name . '.' . $type,
                    null,
                    'pre_auth',
                );
            });
});

/**
 * Add an API key authenticator that looks at the `api_key` query var.
 */
$app['security.api_key.param_name'] = 'api_key';
$app['security.api_key.authenticator'] = $app->share(function() use($app) {
    // ApiKeyAuthenticator from http://symfony.com/doc/current/cookbook/security/api_key_authentication.html
    return new ApiKeyAuthenticator(
            $app['security.user_provider.api'], $app['security.api_key.param_name'], // The Query var name
            $app['logger']
    );
});
$app['security.authentication_listener.factory.api_key'] = $app['security.authentication_listener.pre_auth.factory']('api_key');


$app->register(new \Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'api' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'stateless' => true,
            'api_key' => true, // Our simple API Key authenticator
            'users' => $app->share(function () use ($app,$users) {
                        return new UserProvider($users);
                    })),
    ),
));

$app->get('/api', function (Request $request) {
    return new Response("Hello API");
});

$app
        ->get('/api', 'crick\Controller\ApiController::getPong');

$app
        ->get('/', 'crick\Controller\ApiController::getPong');


$app
        ->get('/api/ping', 'crick\Controller\ApiController::getPong');

return $app = new Negotiation($app, null, null, null, ['format_priorities' => ['html', 'json']]);
