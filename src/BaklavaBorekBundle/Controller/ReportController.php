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
class ReportController extends Controller
{
    /**
     * @Route("/", name="BaklavaBorekBundle_Report_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $orderRepository = $em->getRepository('BaklavaBorekBundle:Order');
        $mailDetailRepository = $em->getRepository('BaklavaBorekBundle:MailDetail');
        $itemRepository = $em->getRepository('BaklavaBorekBundle:Item');

        /* Liars Day Average */
        $day = $average = 0;
        $purchaseDatePassed = $orderRepository->getAvarage();
        if (count($purchaseDatePassed) > 0) {
            for ($i = 0; $i < count($purchaseDatePassed); $i++) {
                $day += (($purchaseDatePassed[$i]->getPurchaseDate()->getTimestamp() - $purchaseDatePassed[$i]->getWillPurchaseDate()->getTimestamp()) / (60 * 60 * 24));
            }
            $average = ceil($day / count($purchaseDatePassed));
        }


        /* Liars (Shame Table) */
        $liarsList = $orderRepository->getLiars();
        $liars = array();
        foreach ($liarsList as $l) {
            $user = $l->getUserId();
            $userId = $user->getId();
            if (!isset($liars[$userId])) {
                $liars[$userId] = array();
                $liars[$userId]["nameSurname"] = (string) $user;
                $liars[$userId]["totalOrderCount"] = count($orderRepository->findByUserId($userId));
                $liars[$userId]["totalPurchaseCount"] = $orderRepository->getTotalPurchaseCountOfUser($userId);
                $liars[$userId]["totalLieCount"] = 1;
            } else {
                $liars[$userId]["totalLieCount"]++;
            }
        }
        // Sort according to lie count desc order
        usort($liars, function($l1, $l2) {
            return $l2["totalLieCount"] - $l1["totalLieCount"];
        });

        /* Top Hunted */
        $hunted = $orderRepository->getHunted();

        /* Top Hunter */
        $hunter = $mailDetailRepository->getHunter();

        /* Top Honest */
        $honest = $orderRepository->getHonest();

        /* Pie Graph Average */
        $pie = $itemRepository->getPie();

        return $this->render('BaklavaBorekBundle:Report:index.html.twig', array(
                "average" => $average,
                "liars" => $liars,
                "huntedList" => $hunted,
                "hunterList" => $hunter,
                "honestList" => $honest,
                "pie" => $pie
            )
        );
    }
}