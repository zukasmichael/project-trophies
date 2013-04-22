<?php

namespace Svnfqt\ProjectTrophies\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'file',
                'file',
                array(
                    'label' => 'Fichier',
                    'constraints' => array(
                        new Assert\Image(array(
                            'maxSize' => '2048k',
                            'mimeTypes' => array('image/png'),
                            'mimeTypesMessage' => 'L\'image doit être au format png',
                            'minWidth' => 400,
                            'maxWidth' => 400,
                            'minHeight' => 400,
                            'maxHeight' => 400
                        ))
                    )
                )
            )
            ->getForm();
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Svnfqt\ProjectTrophies\Document\Image'
        ));
    }

    public function getName()
    {
        return '';
    }
}
