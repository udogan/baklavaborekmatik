<?php

namespace BaklavaBorekBundle\Controller;

use BaklavaBorekBundle\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MeasurementController
 *
 * @package BaklavaBorekBundle\Controller
 * @Route("/report")
 */
class ReportController extends Controller{

    /**
     * @Route("/", name="BaklavaBorekBundle_Report_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $order_repo = $em->getRepository("BaklavaBorekBundle:Order");
        $mail_repo = $em->getRepository("BaklavaBorekBundle:MailDetail");
        $item_repo = $em->getRepository("BaklavaBorekBundle:Item");
        $liars = array();
        $order_t = $order_repo->getOrder_t();
        $order_dates = $order_repo->getLiarsDay();
        $date1 = get_object_vars($order_dates[0]["willPurchaseDate"])["date"];
        $date2 = get_object_vars($order_dates[0]["purchaseDate"])["date"];
        if(count($order_dates) > 0 ) {
            $gun_toplam = 0;
            for ($i = 0; $i < count($order_dates); $i++) {
                $date1 = get_object_vars($order_dates[$i]["willPurchaseDate"])["date"];
                $date2 = get_object_vars($order_dates[$i]["purchaseDate"])["date"];
                $fark = date_diff(date_create($date2), date_create($date1))->days;
                $gun_toplam = $gun_toplam + $fark;
            }
            $avarage = $gun_toplam / count($order_dates);
        }else{
            $avarage = 0;
        }
        for($i = 0; $i<count($order_t); $i++){
            $liars[$order_t[$i]["id"]] = array(
                 "name" => $order_t[$i]["name"],
                 "surname" => $order_t[$i]["surname"],
                 "yalan_sayisi" =>  $order_repo->getLiars($order_t[$i]["id"]),
                 "dogru_sayisi" =>$order_repo->getCurrents($order_t[$i]["id"]));
        }
        $keeps = $order_repo->getKeepPromise();
        $hunteds = $order_repo->getHunted();
        $hunters = $mail_repo->getHunter();
        $productfavorites = $item_repo->getFavoriteProduct();
        $product_data = array();
        for($i = 0; $i<count($productfavorites); $i++) {
            $product_data[] = array("value" => $productfavorites[$i]["siparis_sayisi"], "name" => $productfavorites[$i]["name"]);
        }
        return $this->render('BaklavaBorekBundle:Report:index.html.twig', array(
            "liars" => $liars, "hunteds" => $hunteds,"hunters" => $hunters,"keeps" => $keeps, "productfavorites" =>  $product_data, "avarage" => $avarage
        ));
    }

}