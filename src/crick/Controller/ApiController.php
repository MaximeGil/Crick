<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController
{
    public function getPongAction(Request $request, Application $app)
    {
        $format = $request->attributes->get('_format');
        $user = $app['security']->getToken()->getUser();
        $username = is_object($user) ? $user->getUsername() : $user;

        switch ($format) {
            case 'html':
                return new Response(sprintf('<h1>pong: %s</h1>', $username));
            case 'json':
                return new JsonResponse([
                    'username' => $username,
                    'message' => 'pong',
                ]);
        }
    }
}
