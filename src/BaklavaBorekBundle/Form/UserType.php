<?php

namespace BaklavaBorekBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add("name", new TextType(), array("label" => false, "required" => true))
          ->add("surname", new TextType(), array("label" => false, "required" => true))
          ->add("email", new EmailType(), array("label" => false, "required" => true));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaklavaBorekBundle\Entity\User'
        ));
    }

}