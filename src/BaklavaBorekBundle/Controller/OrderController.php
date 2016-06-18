<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Item;
use BaklavaBorekBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrderController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="BaklavaBorekBundle_Order_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Order");
        $orders = $repository->findAll();
        return $this->render('BaklavaBorekBundle:Order:index.html.twig', array(
          "orders" => $orders
        ));
    }

    /**
     * @Route("/create", name="BaklavaBorekBundle_Order_create")
     */
    public function createAction(Request $request)
    {
        $order = new Order();
        $form = $this->createForm('BaklavaBorekBundle\Form\OrderType', $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_Order_index"));
        }

        return $this->render('BaklavaBorekBundle:Order:create.html.twig', array(
            "form" => $form->createView()
        ));
    }
}