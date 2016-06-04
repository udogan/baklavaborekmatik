<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MailDetail
 *
 * @ORM\Table(name="mail_detail")
 * @ORM\Entity(repositoryClass="BaklavaBorekBundle\Repository\MailDetailRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class MailDetail extends CreatedUpdatedDeletedAt
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
