<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PageController {

    public function getHelloWorld(Application $app) {
        return $app['twig']->render('hello.twig.html');
    }

    public function getLogin(Request $request, Application $app) {
        return $app['twig']->render('login.twig.html', array(
                    'error' => $app['security.last_error']($request),
                    'last_username' => $app['session']->get('_security.last_username'),
        ));
    }

    public function getProfil(Application $app) {
        
    }

}
