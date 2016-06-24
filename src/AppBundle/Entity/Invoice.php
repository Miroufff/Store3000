<?php
/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 12:07
 */

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Invoice
 *
 * @ORM\Entity
 * @ORM\Table(name="t_invoice")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @package AppBundle\Entity
 */
class Invoice
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
     * @ORM\Column(name="date_invoice", type="date")
     * @Expose
     */
    private $dateInvoice;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     * @Expose
     */
    private $total;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(targetEntity="Delivery", mappedBy="order")
     */
    private $deliveries;

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
    public function getDateInvoice()
    {
        return $this->dateInvoice;
    }

    /**
     * @param DateTime $dateInvoice
     */
    public function setDateInvoice($dateInvoice)
    {
        $this->dateInvoice = $dateInvoice;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getDeliveries()
    {
        return $this->deliveries;
    }

    /**
     * @param mixed $deliveries
     */
    public function setDeliveries($deliveries)
    {
        $this->deliveries = $deliveries;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->dateInvoice = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}