<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Form\InitOrderType;
use AppBundle\Form\OrderType;
use AppBundle\Form\TicketType;
use AppBundle\Manager\OrderManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('booking/index.html.twig');
    }


    /**
     * @Route("/booking", name="reservation")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return RedirectResponse|Response
     */
    public function bookOrders(Request $request, OrderManager $orderManager)
    {


        $order = $orderManager->initOrder();

        $form = $this->createForm(InitOrderType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $orderManager->generatingEmptyTickets($order);

            return $this->redirectToRoute("order_step_2");

        }

        return $this->render('booking/bookOrders.html.twig', [
            'form' => $form->createView()

        ]);

    }

    /**
     * @Route("/etape-2", name="order_step_2")
     * @param OrderManager $orderManager
     */
    public function fillTicketsAction( Request $request,OrderManager $orderManager)
    {


        $order = $orderManager->MyCurrentOrder();
        $form = $this->createForm(InitOrderType::class,$order);
        $form->handleRequest($request);
        return $this->render("booking/bookingOrdersView.html.twig",['form'=>$form->createView()]);


    }


}



