<?php

namespace BaklavaBorekBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("mailSentBy", 'entity', array(
                "class" => 'BaklavaBorekBundle:User',
                "label" => false
            ))
            ->add('mailDate', 'date', array(
                'widget' => 'single_text',
                "label" => false
            ))
            ->add('mailBody', 'textarea', array(
                "label" => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BaklavaBorekBundle\Entity\MailDetail'
        ));
    }
}