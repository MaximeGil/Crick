<?php

namespace crick\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use crick\Form\FormRegister;
use Ramsey\Uuid\Uuid;
use crick\Service\UserService;
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
            $password = $app['security.encoder.digest']->encodePassword($data['password'], '');

                $app['db']->getModel('db\Db\PublicSchema\UsersModel')
                ->createAndSave([
                    'uuid' => $uuid,
                    'email' => $data['email'],
                    'password' => $password,
                    'role' => 'ROLE_USER',
                    'api' => $api_key,

                ]);


            $User = new UserService($data['email'], $password, $api_key, 'ROLE_USER');
            $app['security']->setToken(new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($User, $User->getPassword(), $User->getApiKey(), array('ROLE_USER')));
            
            return $app['twig']->render('registrationsuccess.twig.html', array('api_key' => $api_key));
        }

        return $app['twig']->render('register.twig.html', array('form' => $form->createView()));
    }
}
