<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Order
 *
 * @ORM\Table(name="order")
 * @ORM\Entity(repositoryClass="BaklavaBorekBundle\Repository\OrderRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Order extends CreatedUpdatedDeletedAt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
