<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class OrderManager responsable du workflow de commande
 * @package AppBundle\Manager
 */
class OrderManager{
    const SESSION_ORDER_KEY = "SessionKey";

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(SessionInterface $session)
    {

        $this->session = $session;
    }

    /**
     * @return Order
     */
    public function initOrder()
    {
        $order =  new Order();

        $this->session->set(self::SESSION_ORDER_KEY, $order);



        return $order;
    }

    /**
     * @param Order $order
     */
    public function generatingEmptyTickets(Order $order)
    {
        while ($order->getTickets()->count() != $order->getQteOrder()){
            if($order->getTickets()->count() < $order->getQteOrder()){
                $order->addTicket(new Ticket());
            }else{

                     $order->getTickets();

            }
        }
    }

    public function MyCurrentOrder()
    {
        return $this->session->get(self::SESSION_ORDER_KEY);
    }


}