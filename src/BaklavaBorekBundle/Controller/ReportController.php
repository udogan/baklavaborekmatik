<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Report;
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
        return $this->render('BaklavaBorekBundle:Report:index.html.twig');
    }
}