<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 04/12/2018
 * Time: 03:10
 */

namespace Tests\AppBundle\Manager;


use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OrderManagerTest
{
    public function testGeneratingEmptyTickets(SessionInterface $session, EntityManagerInterface $em)
    {

        $orderManager = new OrderManager();
        $order = new Order();
        $ticket = new Ticket();

        $order->setQteOrder(2);

        $order->addTicket($ticket);
        $this->assertEquals($orderManager->generatingEmptyTickets($ticket), 2);
    }
}

