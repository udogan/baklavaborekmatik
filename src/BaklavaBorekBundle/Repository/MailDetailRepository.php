<?php

namespace BaklavaBorekBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MailDetailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MailDetailRepository extends EntityRepository
{
    public function getHunter(){
        return $this->createQueryBuilder("hunter")
            ->select(array("hunter", "u.id", "u.name", "u.surname"))
            ->innerJoin('BaklavaBorekBundle\Entity\user', 'u', 'WITH', 'u.id = hunter.mailSentBy')
            ->addSelect("COUNT(hunter.mailSentBy) as piece")
            ->groupBy("hunter.mailSentBy")
            ->orderBy("piece", "DESC")
            ->getQuery()
            ->getResult();
    }
}
