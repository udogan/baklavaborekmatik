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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:User");
        $users = $repository->findAll();
        return $this->render('BaklavaBorekBundle:User:index.html.twig', array(
            "users" => $users
        ));
    }

    /**
     * @Route("/create", name="BaklavaBorekBundle_User_create")
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('BaklavaBorekBundle\Form\UserType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:User");
        $user = $repository->findOneBy(array("id" => $userId));

        if (!$user) {
            throw $this->createNotFoundException($translator->trans("User Not Found With Id %id%", array("%id%" => $userId)));
        }

        $form = $this->createForm('BaklavaBorekBundle\Form\UserType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
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
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:User");
        $user = $repository->findOneBy(array("id" => $userId));

        if (!$user) {
            throw $this->createNotFoundException($translator->trans("User Not Found With Id %id%", array("%id%" => $userId)));
        }

        $form = $this->createFormBuilder(array('userId' => $userId))
          ->add('userId', 'hidden')
          ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:delete.html.twig', array(
          "form" => $form->createView(),
          "user" => $user
        ));
    }
}