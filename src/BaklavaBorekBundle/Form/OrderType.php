<?php

namespace BaklavaBorekBundle\Form;

use BaklavaBorekBundle\Service\UserService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
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

        $mailDetailType = new MailDetailType($this->userService);

        $builder
          ->add("userId", 'choice', array(
              "choices" => $users,
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
          ))
          ->add("mailDetail", $mailDetailType, array(
              "label" => false
          ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'BaklavaBorekBundle\Entity\Order'
        ));
    }

}