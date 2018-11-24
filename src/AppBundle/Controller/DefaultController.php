<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ContactUs;
use AppBundle\Form\ContactUsType;
use AppBundle\Form\InitOrderType;
use AppBundle\Form\OrderType;
use AppBundle\Manager\ContactManager;
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
     * @return Response
     */
    public function index()
    {

        return $this->render('booking/index.html.twig');


    }

    /**
     * @Route("/contact", name="contact")
     * @param ContactManager $contactManager
     * @return Response
     */
public function contactUs(ContactManager $contactManager, Request $request){

   $contactUs=$contactManager->initContact();
    $form = $this->createForm(ContactUsType::class, $contactUs);



    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $contactManager->sendTheMailFromGuest($contactUs);
        //$orderManager->generatingEmptyTickets($order);
        return $this->redirectToRoute("homepage");



    }
    return $this->render('email/contact.html.twig', [
        'form' => $form->createView()
    ]);
}

    /**
     * @Route("/booking", name="reservation")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return RedirectResponse|Response
     * @throws \Exception
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
     * @param Request $request
     * @param OrderManager $orderManager
     * @return Response
     */
    public function fillTicketsAction(Request $request, OrderManager $orderManager)
    {


        $order = $orderManager->myCurrentOrder();

        $form = $this->createForm(OrderType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $orderManager->computePrice($order);

            return $this->redirectToRoute("order_step_3");

        }

        return $this->render("booking/bookingOrdersView.html.twig", ['form' => $form->createView()]);


    }

    /**
     * @Route("/etape-3", name="order_step_3")
     * @param Request $request
     * @param OrderManager $orderManager
     * @return Response
     */
    public function resumeOrderAction(Request $request, OrderManager $orderManager)
    {

        $order = $orderManager->myCurrentOrder();

        if ($request->isMethod('POST') &&
            $orderManager->doPayment($order)
        ) {

            return $this->redirectToRoute('order_step_4');
        }

        return $this->render("booking/resumeBooking.html.twig", [
            'resumeOrder' => $order,
            'stripe_public_key' => $this->getParameter('stripe_public_key')
        ]);

    }

    /**
     * @Route("/etape-4", name="order_step_4")
     * @param OrderManager $orderManager
     * @return Response
     */
    public function stripeOrder(OrderManager $orderManager)
    {

        return $this->render("email/confirmationBooking.html.twig",[
            'confirmationMail'=>$orderManager->myCurrentOrder()
        ]);

    }


}



