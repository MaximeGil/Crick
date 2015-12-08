<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use crick\Form\FormRegister;

class RegisterController {

    public function registerAction(Request $request, Application $app) {


        $data = array(
            'name' => 'Your Name',
            'email' => 'Your Email',
        );

        $newForm = new FormRegister();
        $form = $newForm->createForm($app);


        if ($form->isValid()) {
            $data = $form->getData();
            
        }
        
        return $app['twig']->render('register.twig.html', array('form' => $form->createView()));
    }

}
