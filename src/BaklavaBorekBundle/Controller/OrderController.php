<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Item;
use BaklavaBorekBundle\Entity\MailDetail;
use BaklavaBorekBundle\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
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
        $translator = $this->get('translator');
        $order = new Order();
        $form = $this->createForm('BaklavaBorekBundle\Form\OrderType', $order);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($order->getItem()->isEmpty()) {
                $form->addError(new FormError($translator->trans("Item cannot be empty")));
            }
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();
                return $this->redirect($this->generateUrl("BaklavaBorekBundle_Order_index"));
            }
        }

        return $this->render('BaklavaBorekBundle:Order:create.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/edit/{orderId}", name="BaklavaBorekBundle_Order_edit")
     */
    public function editAction(Request $request, $orderId)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Order");
        $order = $repository->findOneBy(array("id" => $orderId));

        if (!$order) {
            throw $this->createNotFoundException($translator->trans("Order Not Found With Id %id%", array("%id%" => $orderId)));
        }

        $originalItems = new ArrayCollection();
        // Create an ArrayCollection of the current Item objects in the database
        foreach ($order->getItem() as $item) {
            $originalItems->add($item);
        }

        $form = $this->createForm('BaklavaBorekBundle\Form\OrderType', $order);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($order->getItem()->isEmpty()) {
                $form->addError(new FormError($translator->trans("Item cannot be empty")));
            }
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                // remove the relationship between the tag and the Task
                foreach ($originalItems as $item) {
                    if ($order->getItem()->contains($item) === false) {
                        $em->remove($item);
                    }
                }

                $em->persist($order);
                $em->flush();

                return $this->redirect($this->generateUrl("BaklavaBorekBundle_Order_index"));
            }
        }

        return $this->render('BaklavaBorekBundle:Order:edit.html.twig', array(
            "form" => $form->createView()
        ));
    }

    /**
     * @Route("/delete/{orderId}", name="BaklavaBorekBundle_Order_delete")
     */
    public function deleteAction(Request $request, $orderId)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Order");
        $order = $repository->findOneBy(array("id" => $orderId));

        if (!$order) {
            throw $this->createNotFoundException($translator->trans("Order Not Found With Id %id%", array("%id%" => $orderId)));
        }

        $form = $this->createFormBuilder(array('orderId' => $orderId))
            ->add('orderId', 'hidden')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_Order_index"));
        }

        return $this->render('BaklavaBorekBundle:Order:delete.html.twig', array(
            "form" => $form->createView(),
            "order" => $order
        ));
    }

}