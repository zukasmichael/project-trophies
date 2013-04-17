<?php

namespace Svnfqt\ProjectTrophies\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'username',
                null,
                array(
                    'label' => 'Nom d\'utilisateur',
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add(
                'password',
                'repeated',
                array(
                    'type' => 'password',
                    'invalid_message' => 'Les champs mot de passe doivent être identiques.',
                    'options' => array('label' => 'Mot de passe'),
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Svnfqt\ProjectTrophies\Document\User'
        ));
    }

    public function getName()
    {
        return '';
    }
}
