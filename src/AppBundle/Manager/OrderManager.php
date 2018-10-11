<?php


namespace AppBundle\Manager;


use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class OrderManager responsable du workflow de commande
 * @package AppBundle\Manager
 *
 */
class OrderManager
{
    const SESSION_ORDER_KEY = "SessionKey";

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var PriceManager
     */
    private $priceManager;


    public function __construct(SessionInterface $session, PriceManager $priceManager )
    {

        $this->session = $session;
        $this->priceManager = $priceManager;



    }

    /**
     * @return Order
     */
    public function initOrder()
    {
        $order = new Order();

        $this->session->set(self::SESSION_ORDER_KEY, $order);


        return $order;
    }

    /**
     * @param Order $order
     */
    public function generatingEmptyTickets(Order $order)
    {
        while ($order->getTickets()->count() != $order->getQteOrder()) {
            if ($order->getTickets()->count() < $order->getQteOrder()) {
                $order->addTicket(new Ticket());
            } else {

                $order->getTickets();

            }
        }
    }


    /**
     * @param Order $order
     */
    public function computePrice( Order $order)
    {
 $this->priceManager->computeOrderPrice($order);

    }


    /**
     * @return Order
     * @throws NotFoundHttpException
     */
    public function myCurrentOrder()
    {
        $order = $this->session->get(self::SESSION_ORDER_KEY);


        if($order instanceof Order){
            return $order;
        }else{
            throw new NotFoundHttpException();
        }
    }




}