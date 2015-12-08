<?php

namespace crick\Form;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * Description of FormRegister
 *
 * @author maxime
 */
class FormRegister {

    public function createForm(Application $app) {
        $form = $app['form.factory']->createBuilder()
                ->add('email', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank(), new Assert\Email())))
                ->add('password', RepeatedType::class, array('constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5))), 'type' => PasswordType::class))
                ->getForm();
        return $form;
    }

}
