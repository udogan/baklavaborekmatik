<?php

namespace BaklavaBorekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class UserController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/report")
 */
class ReportController extends Controller
{

    /**
     * @Route("/", name="BaklavaBorekBundle_Report_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository("BaklavaBorekBundle:User");
        $repository2 = $em->getRepository("BaklavaBorekBundle:Order");
        $repository3 = $em->getRepository("BaklavaBorekBundle:MailDetail");
        $repository4 = $em->getRepository("BaklavaBorekBundle:Measurement");

        $query = $repository2->createQueryBuilder('p')
            ->where('p.willPurchaseDate < p.purchaseDate')
            ->setMaxResults(5)
            ->getQuery();

        $a1 = $query->getResult();

        $query2 = $repository2->createQueryBuilder('p')
            ->where('p.willPurchaseDate >= p.purchaseDate')
            ->setMaxResults(5)
            ->getQuery();

        $a2 = $query2->getResult();



        $query3 = $repository3->createQueryBuilder('p')
            ->where('p.mailSentBy = :a11')
            ->set('p.mailSentBy ')
            ->setMaxResults(5)
            ->getQuery();

        $a3 = $query3->getResult();






        return $this->render('BaklavaBorekBundle:Report:index.html.twig', array(
            "users" => $a1,
            "users2" => $a2
        ));
    }
}
