<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="BaklavaBorekBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Item extends CreatedUpdatedDeletedAt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    //1
    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    // tepsi
    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Measurement")
     * @ORM\JoinColumn(name="measurement_id", referencedColumnName="id")
     */
    private $measurementId;

    // baklava
    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getMeasurementId()
    {
        return $this->measurementId;
    }

    /**
     * @param int $measurementId
     */
    public function setMeasurementId($measurementId)
    {
        $this->measurementId = $measurementId;
    }

    /**
     * @return int
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param int $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

}
