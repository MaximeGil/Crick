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

    public function getProjects(Request $request, Application $app) {
        
        $username = $app['security']->getToken()->getUser()->getUsername();

        // on récupère l'uuid de l'utilisateur en cours
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\UsersModel')
                ->findUuidByName($username);
        
        $uuid = $result->get(0)->getUuid();
        
        $result = $app['db']
                ->getModel('db\Db\PublicSchema\ProjectModel')
                ->findWhere('uuid = $*', [$uuid]);
        
        extract($result);
        var_dump($result);
        die();
    }

}
