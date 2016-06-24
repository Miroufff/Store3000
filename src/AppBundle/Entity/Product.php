<?php
/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 12:06
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Product
 *
 * @ORM\Entity
 * @ORM\Table(name="t_product")
 * @ExclusionPolicy("all")
 * @package AppBundle\Entity
 */
class Product
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
     * @ORM\Column(name="name", type="string", length=250)
     * @Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=500)
     * @Expose
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Expose
     */
    private $price;

    /**
     * @var mixed
     *
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="product")
     */
    private $orderDetails;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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

    public function __toString() {
        return $this->name;
    }
}