<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class PaymentService
{
    private $privateKey;
    private $request;

    public function __construct($privateKey, RequestStack $requestStack)
    {
        $this->privateKey = $privateKey;
        $this->request = $requestStack->getCurrentRequest();
    }


    public function doPayment( $amount, $desc)
    {

            $token = $this->request->get('stripeToken');

            \Stripe\Stripe::setApiKey($this->privateKey);
            try {
                $charge = \Stripe\Charge::create(array(
                    "amount" => $amount * 100,
                    "currency" => "eur",
                    "source" => $token,
                    "description" => $desc
                ));


            } catch (\Exception $e) {
                return false;
            }

            return $charge['id'];

    }



}