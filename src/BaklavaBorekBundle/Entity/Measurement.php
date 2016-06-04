<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement")
 * @ORM\Entity(repositoryClass="BaklavaBorekBundle\Repository\MeasurementRepository")
 */
class Measurement
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
