<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;

class StripeManager
{


    public function stripePayement(Request $request, Order $order)
    {

            $token = $request->request->get('stripeToken');

            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            try {
                \Stripe\Charge::create(array(
                    "amount" => $order->getPrice() * 100,
                    "currency" => "eur",
                    "source" => $token,
                    "description" => "Votre commande pour telle date "
                ));


            } catch (\Exception $e) {

            }

    }
}