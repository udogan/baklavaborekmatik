<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Measurement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MeasurementController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/measurement")
 */
class MeasurementController extends Controller
{
    /**
     * @Route("/", name="BaklavaBorekBundle_Measurement_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Measurement");
        $measurement = $repository->findAll();

        return $this->render('BaklavaBorekBundle:Measurement:index.html.twig', array(
            "measurements" => $measurement
        ));
    }


    /**
     * @Route("/create", name="BaklavaBorekBundle_Measurement_create")
     */
    public function createAction(Request $request)
    {
        $measurement = new Measurement();
        $form = $this->createForm('BaklavaBorekBundle\Form\MeasurementType', $measurement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($measurement);
            $em->flush();

            return $this->redirect($this->generateUrl("BaklavaBorekBundle_Measurement_index"));
        }

        return $this->render('BaklavaBorekBundle:Measurement:create.html.twig', array(
            "form" => $form->createView()
        ));
    }


    /**
     * @Route("/edit/{measurementId}", name="BaklavaBorekBundle_Measurement_edit")
     */
    public function editAction(Request $request, $measurementId)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Measurement");
        $measurement = $repository->findOneBy(array("id" => $measurementId));

        if (!$measurement) {
            throw $this->createNotFoundException($translator->trans("Measurement Not Found With Id %id%", array("%id%" => $measurementId)));
        }

        $form = $this->createForm('BaklavaBorekBundle\Form\MeasurementType', $measurement);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($measurement);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_Measurement_index"));
        }

        return $this->render('BaklavaBorekBundle:Measurement:edit.html.twig', array(
            "form" => $form->createView()
        ));
    }


    /**
     * @Route("/delete/{measurementId}", name="BaklavaBorekBundle_Measurement_delete")
     */
    public function deleteAction(Request $request, $measurementId)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Measurement");
        $measurement = $repository->findOneBy(array("id" => $measurementId));

        if (!$measurement) {
            throw $this->createNotFoundException($translator->trans("Are you sure want to delete Measurement <i>%name%</i> ?", array("%name%" => $measurement.name)));
        }

        $form = $this->createFormBuilder(array('measurementID' => $measurementId))
            ->add('measurementID', 'hidden')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($measurement);
            $em->flush();
            return $this->redirect($this->generateUrl("BaklavaBorekBundle_Measurement_index"));
        }

        return $this->render('BaklavaBorekBundle:Measurement:delete.html.twig', array(
            "form" => $form->createView(),
            "measurement" => $measurement
        ));
    }
}