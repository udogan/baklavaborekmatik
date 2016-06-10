<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="Item")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var \DateTime $willPurchaseDate
     *
     * @ORM\Column(type="datetime")
     */
    private $willPurchaseDate;

    /**
     * @var \DateTime $purchaseDate
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $purchaseDate;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param int $item
     */
    public function setItem($item)
    {
        $this->item = $item;
    }

    /**
     * @return \DateTime
     */
    public function getWillPurchaseDate()
    {
        return $this->willPurchaseDate;
    }

    /**
     * @param \DateTime $willPurchaseDate
     */
    public function setWillPurchaseDate($willPurchaseDate)
    {
        $this->willPurchaseDate = $willPurchaseDate;
    }

    /**
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * @param \DateTime $purchaseDate
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;
    }

}
