<?php

namespace BaklavaBorekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Order")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="mail_sent_by", referencedColumnName="id")
     */
    private $mailSentBy;

    /**
     * @var \DateTime $mailDate
     *
     * @ORM\Column(type="datetime")
     */
    private $mailDate;


    /**
     * @var String
     *
     * @ORM\Column(type="text")
     */
    private $mailBody;

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
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getMailSentBy()
    {
        return $this->mailSentBy;
    }

    /**
     * @param int $mailSentBy
     */
    public function setMailSentBy($mailSentBy)
    {
        $this->mailSentBy = $mailSentBy;
    }

    /**
     * @return \DateTime
     */
    public function getMailDate()
    {
        return $this->mailDate;
    }

    /**
     * @param \DateTime $mailDate
     */
    public function setMailDate($mailDate)
    {
        $this->mailDate = $mailDate;
    }

    /**
     * @return String
     */
    public function getMailBody()
    {
        return $this->mailBody;
    }

    /**
     * @param String $mailBody
     */
    public function setMailBody($mailBody)
    {
        $this->mailBody = $mailBody;
    }

}
