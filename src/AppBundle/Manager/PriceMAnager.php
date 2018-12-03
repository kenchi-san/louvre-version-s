<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Symfony\Component\Validator\Tests\Fixtures\ConstraintAValidator;

/**
 * Class PriceManager
 *
 * @package AppBundle\Manager
 */
class PriceManager extends ConstraintAValidator
{


    const PRIX_BEBE = 0;
    const PRIX_NORMAL = 16;
    const PRIX_ENFANT = 8;
    const PRIX_SENIOR = 12;
    const PRIX_REDUIT = 10;


    const AGE_ENFANT = 4;
    const AGE_ADULTE = 12;
    const AGE_SENIOR = 60;

    const COEF_DEMI_JOURNEE = 0.5;

    /**
     * Calculer les prix des tickets d'une commande et le prix total
     * @param Order $order
     * @return int
     */
    public function computeOrderPrice(Order $order)
    {
        $totalPrice = 0;
        foreach ($order->getTickets() as $ticket) {


            $totalPrice += $this->computeTicketPrice($ticket);


        }

        $order->setPrice($totalPrice);

        return $totalPrice;

    }


    /**
     * Calcul le prix d'un ticket en fonction de la date/durée de la visite et de l'application du tarif réduit
     *
     * @param Ticket $ticket
     * @return int
     */
    public function computeTicketPrice(Ticket $ticket)
    {
        if ($ticket->getOrder()->getTypeOrder() === Order::TYPE_FULL_DAY) {
            if ($ticket->getDiscount()) {
                $price = (self::PRIX_REDUIT);
            } elseif ($ticket->getAge() < self::AGE_ENFANT) {
                $price = (self::PRIX_BEBE);
            } elseif ($ticket->getAge() < self::AGE_ADULTE) {
                $price = (self::PRIX_ENFANT);
            } elseif ($ticket->getAge() < self::AGE_SENIOR) {
                $price = (self::PRIX_NORMAL);
            } else {
                $price = (self::PRIX_SENIOR);
            }
        } else {
            if ($ticket->getDiscount()) {
                $price = (self::PRIX_REDUIT * self::COEF_DEMI_JOURNEE);
            } elseif ($ticket->getAge() < self::AGE_ENFANT) {
                $price = (self::PRIX_BEBE * self::COEF_DEMI_JOURNEE);
            } elseif ($ticket->getAge() < self::AGE_ADULTE) {
                $price = (self::PRIX_ENFANT * self::COEF_DEMI_JOURNEE);
            } elseif ($ticket->getAge() < self::AGE_SENIOR) {
                $price = (self::PRIX_NORMAL * self::COEF_DEMI_JOURNEE);
            } else {
                $price = (self::PRIX_SENIOR * self::COEF_DEMI_JOURNEE);
            }

        }

        $ticket->setPrice($price);

        return $price;
    }


}

