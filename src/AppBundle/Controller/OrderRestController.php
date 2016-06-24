<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Order;
use AppBundle\Form\OrderType;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Util\Codes;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Order controller.
 *
 */
class OrderRestController extends FOSRestController
{
    /**
     * @return array
     * @View()
     */
    public function getOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('AppBundle:Order')->findAll();

        return array('orders' => $orders);
    }

    /**
     * @param Order $order
     * @return array
     * @View()
     * @ParamConverter("order", class="AppBundle:Order")
     */
    public function getOrderAction(Order $order)
    {
        return array('order' => $order);
    }
}
