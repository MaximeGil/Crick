<?php

namespace crick\Form;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * Description of FormRegister.
 *
 * @author maxime
 */
class FormProject
{
    public function createForm(Application $app)
    {
        $form = $app['form.factory']->createBuilder()
                ->add('name', TextType::class, array(
                    'constraints' => array(new Assert\NotBlank())))
                ->getForm();

        return $form;
    }
}
