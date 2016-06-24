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
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * Lists all Order entities.
     *
     * @Get("/", name="order_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orders = $em->getRepository('AppBundle:Order')->findAll();

        return $this->render('order/index.html.twig', array(
            'orders' => $orders,
        ));
    }

    /**
     * Creates a new Order entity.
     *
     * @Route("/new", name="order_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $em->getRepository('AppBundle:Customer')->findOneBy(array("id" => 1));

        $order = new Order();
        $order->setRef($this->container->get('app.refgenerator')->getLastInsertedId('Order'));
        $order->setCustomer($customer);

        $em->persist($order);
        $em->flush();

        return $this->redirectToRoute('order_show', array('id' => $order->getId()));
    }

    /**
     * Finds and displays a Order entity.
     *
     * @Route("/{id}", name="order_show")
     * @Method("GET")
     */
    public function showAction(Order $order)
    {
        $deleteForm = $this->createDeleteForm($order);

        $em = $this->getDoctrine()->getManager();

        $orderDetails = $em->getRepository('AppBundle:OrderDetail')->findBy(array("order" => $order));
        $deliveries = $em->getRepository('AppBundle:Delivery')->findBy(array("order" => $order));

        if ($deliveries) {
            $invoice = $deliveries[0]->getInvoice();
        } else {
            $invoice = null;
        }

        return $this->render('order/show.html.twig', array(
            'order' => $order,
            'orderdetails' => $orderDetails,
            'invoice' => $invoice,
            'deliveries' => $deliveries,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Order entity.
     *
     * @Route("/{id}/edit", name="order_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Order $order)
    {
        $deleteForm = $this->createDeleteForm($order);
        $editForm = $this->createForm('AppBundle\Form\OrderType', $order);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return $this->redirectToRoute('order_edit', array('id' => $order->getId()));
        }

        return $this->render('order/edit.html.twig', array(
            'order' => $order,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Order entity.
     *
     * @Route("/{id}", name="order_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Order $order)
    {
        $form = $this->createDeleteForm($order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($order);
            $em->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    /**
     * Creates a form to delete a Order entity.
     *
     * @param Order $order The Order entity
     *
     * @return \Symfony\Component\Form\Form The formuse FOS\RestBundle\Controller\Annotations as Rest,
     */
    private function createDeleteForm(Order $order)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('order_delete', array('id' => $order->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
