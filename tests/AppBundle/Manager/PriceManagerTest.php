<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 02/12/2018
 * Time: 12:29
 */

namespace Tests\AppBundle\Manager;


use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use AppBundle\Manager\PriceManager;
use PHPUnit\Framework\TestCase;

class PriceManagerTest extends TestCase
{
    //const COEF_DEMI_JOURNEE = 0.5;

    /**
     */
    public function testComputeOrderPrice()
    {
        $priceManager = new PriceManager();
        $order = new Order();
        $order->setTypeOrder(Order::TYPE_FULL_DAY);
        $order->setBookingDate(new \DateTime('2018-01-1'));

        $ticket1 = new Ticket();
        $ticket1->setBirthday(new \DateTime('2000-01-1'));
        $ticket1->setDiscount(false);

        $ticket2 = new Ticket();
        $ticket2->setBirthday(new \DateTime('2010-01-1'));
        $ticket2->setDiscount(false);

        $order->addTicket($ticket1);
        $order->addTicket($ticket2);



        $this->assertSame($priceManager->computeOrderPrice($order),24 );

    }

    /**
     * @param \DateTime $birthdate
     * @param bool $reduce
     * @param $type
     * @param \DateTime $bookingDate
     * @param $expectedPrice
     *
     * @dataProvider computeTicketPriceProvider
     */
    public function testComputeTicketPrice(\DateTime $birthdate, bool $reduce, $type, \DateTime $bookingDate, $expectedPrice)
    {
        $priceManager = new PriceManager();

        $ticket = new Ticket();
        $ticket->setBirthday($birthdate);
        $ticket->setDiscount($reduce);

        $order = new Order();
        $order->setTypeOrder($type);
        $order->setBookingDate($bookingDate);
        $order->addTicket($ticket);

        $this->assertEquals($priceManager->computeTicketPrice($ticket), $expectedPrice);
    }

    public function computeTicketPriceProvider()
    {

        return [
            [new \DateTime('2000-01-1'), false, Order::TYPE_FULL_DAY, new \DateTime('2018-01-1'), PriceManager::PRIX_NORMAL],
            [new \DateTime('2000-01-1'), true, Order::TYPE_FULL_DAY, new \DateTime('2018-01-1'), PriceManager::PRIX_REDUIT],
            [new \DateTime('2000-01-1'), true, Order::TYPE_HALF_DAY, new \DateTime('2018-01-1'), PriceManager::PRIX_REDUIT * PriceManager::COEF_DEMI_JOURNEE]
        ];
    }


}



