<?php

namespace BaklavaBorekBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('BaklavaBorekBundle:Default:index.html.twig');
    }

    /**
     * @Route("/getCalendarEvents")
     * @Method({"GET"})
     */
    public function getCalendarEventsAction(Request $request)
    {
        $startDate = $request->query->get('start');
        $endDate = $request->query->get('end');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("BaklavaBorekBundle:Order");
        $queryBuilder = $repository->createQueryBuilder('o');

        $query = $queryBuilder
          ->where("o.willPurchaseDate BETWEEN :start AND :end")
          ->andWhere($queryBuilder->expr()->isNull('o.purchaseDate'))
          ->setParameter("start", date('Y-m-d 00:00:00', $startDate))
          ->setParameter("end", date('Y-m-d 00:00:00', $endDate));
        $result = $query->getQuery()->execute();

        $returnResult = array();
        foreach ($result as $r) {
            $returnItem = array(
              "nameSurname" => $r->getUserId()->__toString(),
              "date" => $r->getWillPurchaseDate()->format("Y-m-d"),
              "item" => array()
            );
            foreach ($r->getItem() as $i) {
                $returnItem["item"][] = $i->__toString();
            }
            $returnResult[] = $returnItem;
        }

        return new JsonResponse(array("result" => $returnResult));
    }
}