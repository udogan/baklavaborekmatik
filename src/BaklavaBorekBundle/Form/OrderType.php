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
          ->add("userId", 'entity', array(
              "class" => 'BaklavaBorekBundle:User',
              "label" => false
          ))
          ->add("item", 'collection', array(
              "entry_type" => 'BaklavaBorekBundle\Form\ItemType',
              "allow_add" => true,
              "allow_delete" => true,
              "by_reference" => false,
              "label" => false
          ))
          ->add('willPurchaseDate', 'date', array(
              'widget' => 'single_text',
              "label" => false
          ))
          ->add('purchaseDate', 'date', array(
              'widget' => 'single_text',
              "label" => false,
              "required" => false
          ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'BaklavaBorekBundle\Entity\Order'
        ));
    }

}