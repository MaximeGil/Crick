<?php

namespace crick\Controller;

use Silex\Application;

class PageController
{
    public function getHelloWorld(Application $app)
    {
        return $app['twig']->render('hello.twig.html');
    }
}
