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
     * @Route("/", name="BaklavaBorakBundle_User_index")
     */
    public function indexAction()
    {
        return $this->render('BaklavaBorekBundle:User:index.html.twig');
    }

    /**
     * @Route("/create")
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
            return $this->redirect($this->generateUrl("BaklavaBorakBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{userId}")
     */
    public function editAction(Request $request, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:User");
        $user = $repository->findOneBy(array("id" => $userId));
        $form = $this->createForm('BaklavaBorekBundle\Form\UserType', $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorakBundle_User_index"));
        }

        return $this->render('BaklavaBorekBundle:User:edit.html.twig', array(
          "form" => $form->createView()
        ));
    }
}