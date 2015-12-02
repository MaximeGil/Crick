<?php

namespace crick\Controller;

use Silex\Application;

class PageController
{
    public function getHelloWorld(Application $app)
    { 
        return $app['twig']->render('hello.twig.html');
    }
    
    public function getRegisterPage(Application $app)
    {
        return $app['twig']->render('register.twig.html');
    }
}
