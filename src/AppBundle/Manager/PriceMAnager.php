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
    const PRIX_BEBE = 0;
    const PRIX_NORMAL = 16;
    const PRIX_ENFANT = 8;
    const PRIX_SENIOR = 12;
    const PRIX_REDUIT = 10;


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
          return $this->computeTicketPrice($ticket);
        }

    }

    /**
     * @param Ticket $ticket
     */
    public function computeTicketPrice(Ticket $ticket)
    {

        if ($ticket->getAge() < self::AGE_ENFANT) {
            $ticket->setPrice(self::PRIX_BEBE);
        } elseif ($ticket->getAge() >= self::AGE_ENFANT && $ticket->getAge() <= self::AGE_ADULTE) {
            $ticket->setPrice(self::PRIX_ENFANT);
        } elseif ($ticket->getAge() >= self::AGE_SENIOR) {
            $ticket->setPrice(self::PRIX_SENIOR);
        } elseif ($ticket->getAge() >= self::AGE_ADULTE && $ticket->getAge() <= self::AGE_SENIOR) {
            $ticket->setPrice(self::PRIX_NORMAL);

        }elseif ($ticket->getDiscount() === true) {
        $ticket->setPrice(self::PRIX_REDUIT);
    }
        else {
            $ticket->setPrice(self::PRIX_NORMAL);
        }



    }
}
/* $computePrice = 0;


         $ticket->getOrder()->getTypeOrder();
         $ticket->setPrice($computePrice);
         return $computePrice;*/

