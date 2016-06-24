<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Delivery;
use AppBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\OrderDetail;
use AppBundle\Form\OrderDetailType;

/**
 * OrderDetail controller.
 *
 * @Route("/orderdetail")
 */
class OrderDetailController extends Controller
{
    /**
     * Lists all OrderDetail entities.
     *
     * @Route("/", name="orderdetail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $orderDetails = $em->getRepository('AppBundle:OrderDetail')->findAll();

        return $this->render('orderdetail/index.html.twig', array(
            'orderDetails' => $orderDetails,
        ));
    }

    /**
     * Creates a new OrderDetail entity.
     *
     * @Route("/new/{id}", name="orderdetail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Order $order)
    {
        $orderDetail = new OrderDetail();
        $orderDetail->setOrder($order);
        $form = $this->createForm('AppBundle\Form\OrderDetailType', $orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $orderDetailExist = $em->getRepository('AppBundle:OrderDetail')->findOneBy(
                array(
                    "order"   => $order,
                    "product" => $orderDetail->getProduct()
                )
            );

            if ($orderDetailExist != null) {
                $orderDetailExist->setAmount($orderDetailExist->getAmount() + $orderDetail->getAmount());
                $orderDetail = $orderDetailExist;
            }

            $delivery = new Delivery();
            $delivery->setRef($this->container->get('app.refgenerator')->getLastInsertedId('Delivery'));
            $delivery->setOrder($order);

            $em->persist($delivery);
            $em->persist($orderDetail);
            $em->flush();

            return $this->redirectToRoute('order_show', array('id' => $order->getId()));
        }

        return $this->render('orderdetail/new.html.twig', array(
            'orderDetail' => $orderDetail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrderDetail entity.
     *
     * @Route("/{id}", name="orderdetail_show")
     * @Method("GET")
     */
    public function showAction(OrderDetail $orderDetail)
    {
        $deleteForm = $this->createDeleteForm($orderDetail);

        return $this->render('orderdetail/show.html.twig', array(
            'orderDetail' => $orderDetail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderDetail entity.
     *
     * @Route("/{id}/edit", name="orderdetail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OrderDetail $orderDetail)
    {
        $deleteForm = $this->createDeleteForm($orderDetail);
        $editForm = $this->createForm('AppBundle\Form\OrderDetailType', $orderDetail);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($orderDetail);
            $em->flush();

            return $this->redirectToRoute('orderdetail_edit', array('id' => $orderDetail->getId()));
        }

        return $this->render('orderdetail/edit.html.twig', array(
            'orderDetail' => $orderDetail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a OrderDetail entity.
     *
     * @Route("/{id}", name="orderdetail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OrderDetail $orderDetail)
    {
        $form = $this->createDeleteForm($orderDetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($orderDetail);
            $em->flush();
        }

        return $this->redirectToRoute('orderdetail_index');
    }

    /**
     * Creates a form to delete a OrderDetail entity.
     *
     * @param OrderDetail $orderDetail The OrderDetail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OrderDetail $orderDetail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderdetail_delete', array('id' => $orderDetail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
