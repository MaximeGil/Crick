<?php

use crick\Security\Api\ApiKeyAuthentificator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Provider\SimpleAuthenticationProvider;
use Symfony\Component\Security\Http\Firewall\SimplePreAuthenticationListener;

$app['security.authentication_listener.pre_auth.factory'] = $app->protect(function ($type) use ($app) {
    return $app->protect(function ($name, $options) use ($app, $type) {

        $app['security.authentication_listener.' . $name . '.' . $type] = $app->share(function () use ($app, $name, $options, $type) {
            return new SimplePreAuthenticationListener(
                $app['security'],
                $app['security.authentication_manager'],
                $name,
                $app['security.' . $type . '.authenticator'],
                $app['logger']
            );
        });

        $app['security.authentication_provider.' . $name . '.' . $type] = $app->share(function () use ($app, $name, $type) {
            return new SimpleAuthenticationProvider(
                $app['security.' . $type . '.authenticator'],
                $app['security.user_provider.' . $name],
                $name
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
$app['security.api_key.authenticator'] = $app->share(function () use ($app) {
    // ApiKeyAuthenticator from http://symfony.com/doc/current/cookbook/security/api_key_authentication.html
    return new ApiKeyAuthentificator(
        $app['security.api_key.param_name'] // The Query var name
    );
});
$app['security.authentication_listener.factory.api_key'] = $app['security.authentication_listener.pre_auth.factory']('api_key');
