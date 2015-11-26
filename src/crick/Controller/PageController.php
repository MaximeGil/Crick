<?php

namespace crick\Controller;

use Silex\Application;

class PageController
{
    public function getPong(Application $app)
    { 
        return $app['twig']->render('hello.twig.html');
    }
}
