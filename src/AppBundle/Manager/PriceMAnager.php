<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Symfony\Component\Validator\Tests\Fixtures\ConstraintAValidator;

/**
 * Class PriceManager
 * Calcule le prix d'une commande ou d'un ticket en fonction de la date de visite et de l'age
 * @package AppBundle\Manager
 */
class PriceManager extends ConstraintAValidator
{
    const PRIX_NORMAL = 16;
    const PRIX_ENFANT = 8;
    const PRIX_SENIOR = 12;
    const PRIX_REDUIT = 10;

    const AGE_BEBE = 0;
    const AGE_ENFANT = 4;
    const AGE_ADULTE = 12;
    const AGE_SENIOR = 60;

    /**
     * Calculer les prix des tickets d'une commande et le prix total
     * @param Order $order
     */
    public function computeOrderPrice(Order $order)
    {


        foreach ($order->getTickets() as $ticket) {
            $this->computeTicketPrice($ticket);
        }
    }

    /**
     * @param Ticket $ticket
     */
    private function computeTicketPrice(Ticket $ticket)
    {

        /* $computePrice = 0;
         $ticket->getDiscount();
         $ticket->getAge();
         $ticket->getOrder()->getTypeOrder();


         $ticket->setPrice($computePrice);
         return $computePrice;*/
    }

}