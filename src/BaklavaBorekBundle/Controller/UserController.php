<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class UserController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="BaklavaBorekBundle_User_index")
     */
    public function indexAction()
    {
        $userService = $this->container->get("baklavaborek.service.user");
        $users = $userService->getAllUsers();
        return $this->render('BaklavaBorekBundle:User:index.html.twig', array(
            "users" => $users
        ));
    }

    /**
     * @Route("/create", name="BaklavaBorekBundle_User_create")
     */
    public function createAction(Request $request)
    {
        $userService = $this->container->get("baklavaborek.service.user");

        $form = $this->createForm('BaklavaBorekBundle\Form\UserType');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->createUser((Object) $form->getData());
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{userId}", name="BaklavaBorekBundle_User_edit")
     */
    public function editAction(Request $request, $userId)
    {
        $translator = $this->get('translator');
        $userService = $this->container->get("baklavaborek.service.user");
        $user = $userService->getUser($userId);

        if (!$user) {
            throw $this->createNotFoundException($translator->trans("User Not Found With Id %id%", array("%id%" => $userId)));
        }

        $form = $this->createForm('BaklavaBorekBundle\Form\UserType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->editUser($user);
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:edit.html.twig', array(
          "form" => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{userId}", name="BaklavaBorekBundle_User_delete")
     */
    public function deleteAction(Request $request, $userId)
    {
        $translator = $this->get('translator');
        $userService = $this->container->get("baklavaborek.service.user");
        $user = $userService->getUser($userId);

        if (!$user) {
            throw $this->createNotFoundException($translator->trans("User Not Found With Id %id%", array("%id%" => $userId)));
        }

        $form = $this->createFormBuilder(array('userId' => $userId))
          ->add('userId', 'hidden')
          ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userService->deleteUser($userId);
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:delete.html.twig', array(
          "form" => $form->createView(),
          "user" => $user
        ));
    }
}