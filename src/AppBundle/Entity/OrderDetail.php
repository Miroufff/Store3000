<?php

/**
 * Created by PhpStorm.
 * User: mirouf
 * Date: 23/06/16
 * Time: 12:05
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class OrderDetail
 *
 * @ORM\Entity
 * @ORM\Table(name="t_order_detail")
 * @ExclusionPolicy("all")
 * @package AppBundle\Entity
 */
class OrderDetail
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
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     * @Expose
     */
    private $amount;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Order")
     * @ORM\JoinColumn(name="id_order", referencedColumnName="id")
     */
    private $order;

    /**
     * @var mixed
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id")
     * @Expose
     */
    private $product;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }
}