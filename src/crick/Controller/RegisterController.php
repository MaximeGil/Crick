<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use crick\Form\FormRegister;
use Ramsey\Uuid\Uuid;
use crick\Security\Api\ApiKeyGenerator;

class RegisterController
{
    public function registerAction(Request $request, Application $app)
    {
        $data = array(
            'email' => 'Your email',
            'password' => 'Your password',
        );

        $newForm = new FormRegister();
        $form = $newForm->createForm($app);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $uuid = Uuid::uuid1()->toString();
            $api_key = ApiKeyGenerator::generateKey();
            $api_key = base64_encode($api_key);

            $app['db']->getModel('db\Db\PublicSchema\UsersModel')
            ->createAndSave([
                'uuid' => $uuid = $uuid,
                'emailuser' => $data['email'],
                'passworduser' => $data['password'],
                'role' => 'ROLE_USER',
                'apiuser' => $api_key,

            ]);

            return $app['twig']->render('registrationsuccess.twig.html', array('api_key' => $api_key));
        }

        return $app['twig']->render('register.twig.html', array('form' => $form->createView()));
    }
}
