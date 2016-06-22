<?php

namespace BaklavaBorekBundle\Form;


use BaklavaBorekBundle\Service\UserService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailDetailType extends AbstractType
{
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $users = array();
        foreach ($this->userService->getAllUsers() as $u) {
            $users[$u->id] = $u->name . " " . $u->surname;
        }

        $builder
            ->add("mailSentBy", 'choice', array(
                "choices" => $users,
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