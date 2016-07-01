<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReportController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/report")
 */
class ReportController extends Controller{
    /**
     * @Route("/", name="BaklavaBorekBundle_Report_index")
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        /* Liars Avarage */
        $day = 0;
        $avarage = $em->getRepository('BaklavaBorekBundle:Order')->getAvarage();
        if(count($avarage) > 0){
            for($i=0; $i<count($avarage); $i++){
                $day = (($avarage[$i]->getPurchaseDate()->getTimestamp()-$avarage[$i]->getWillPurchaseDate()->getTimestamp())/(60*60*24));
            }
            $avarage = $day / count($avarage);
        }


        /* The Liar */
        $liars = $em->getRepository('BaklavaBorekBundle:Order')->getLiars();
        $liars_array = array();
        $liars_m = array("users" => array());
        for($i=0; $i<count($liars); $i++){
            if(array_search($liars[$i]->getUserId()->getId(), $liars_array) === false){
                array_push($liars_array, $liars[$i]->getUserId()->getId());
                array_push($liars_m["users"], $liars[$i]);
            }

            $liars_m["correct_number"][$liars[$i]->getUserId()->getId()] = $em->getRepository('BaklavaBorekBundle:Order')->getCorrectNumber($liars[$i]->getUserId()->getId());
            $liars_m["liars_count"][$liars[$i]->getUserId()->getId()] = ((isset($liars_m["liars_count"][$liars[$i]->getUserId()->getId()])) === false ? 1 : $liars_m["liars_count"][$liars[$i]->getUserId()->getId()] + 1);
        }
        

        /* Most Who Hunted */
        $hunted = $em->getRepository('BaklavaBorekBundle:Order')->getHunted();

        /* Most Who Catch */
        $hunter = $em->getRepository('BaklavaBorekBundle:MailDetail')->getHunter();

        /* The Plant in Most People */
        $honest = $em->getRepository('BaklavaBorekBundle:Order')->getHonest();

        /* Pie Graph Avarage */
        $pie = $em->getRepository('BaklavaBorekBundle:Item')->getPie();

        return $this->render('BaklavaBorekBundle:Report:index.html.twig', array(
            "avarage"     => $avarage,
            "liars"       => $liars_m,
            "hunted_list" => $hunted,
            "hunter_list" => $hunter,
            "honest_list" => $honest,
            "pie"         => $pie
        ));
    }
}