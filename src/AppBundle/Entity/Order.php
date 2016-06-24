<?php
/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 12:06
 */

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Order
 *
 * @ORM\Entity
 * @ORM\Table(name="t_order")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 * @package AppBundle\Entity
 */
class Order
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
     * @ORM\Column(name="date_creation", type="date")
     * @Expose
     */
    private $dateCreation;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="order")
     * @Expose
     */
    private $orderDetails;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(targetEntity="Delivery", mappedBy="order")
     * @Expose
     */
    private $deliveries;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id")
     * @Expose
     */
    private $customer;

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
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param DateTime $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * @return mixed
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * @param mixed $orderDetails
     */
    public function setOrderDetails($orderDetails)
    {
        $this->orderDetails = $orderDetails;
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
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->dateCreation = new \DateTime('now', new \DateTimeZone('UTC'));
    }
}