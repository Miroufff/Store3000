<?php
/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 12:07
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Delivery
 *
 * @ORM\Entity
 * @ORM\Table(name="t_delivery")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @package AppBundle\Entity
 */
class Delivery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ref", type="string", length=100)
     * @Expose
     */
    private $ref;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date_delivery", type="date")
     * @Expose
     */
    private $dateDelivery;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order")
     * @ORM\JoinColumn(name="id_order", referencedColumnName="id")
     */
    private $order;

    /**
     * @var Invoice
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Invoice")
     * @ORM\JoinColumn(name="id_invoice", referencedColumnName="id")
     * @Expose
     */
    private $invoice;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return DateTime
     */
    public function getDateDelivery()
    {
        return $this->dateDelivery;
    }

    /**
     * @param DateTime $dateDelivery
     */
    public function setDateDelivery($dateDelivery)
    {
        $this->dateDelivery = $dateDelivery;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param Invoice $invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->dateDelivery = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}