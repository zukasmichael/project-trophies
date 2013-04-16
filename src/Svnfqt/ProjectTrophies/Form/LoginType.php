<?php

namespace Svnfqt\ProjectTrophies\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                '_username',
                null,
                array(
                    'label' => 'Nom d\'utilisateur',
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add(
                '_password',
                'password',
                array(
                    'label' => 'Mot de passe',
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->getForm();
    }

    public function getName()
    {
        return '';
    }
}
