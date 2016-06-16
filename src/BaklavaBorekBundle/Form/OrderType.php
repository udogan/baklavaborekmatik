<?php

namespace BaklavaBorekBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add("item", 'entity', array(
            "class" => 'BaklavaBorekBundle:Item'
          ))
          ->add("userId", 'entity', array(
              "class" => 'BaklavaBorekBundle:User'
          ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'BaklavaBorekBundle\Entity\Order'
        ));
    }

}