<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Order;
use AppBundle\Entity\Ticket;
use AppBundle\Services\MailerService;
use AppBundle\Services\PaymentService;
use Doctrine\ORM\EntityManagerInterface;
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
     * @var PaymentService
     */
    private $paymentService;
    /**
     * @var PriceManager
     */
    private $priceManager;
    /**
     * @var MailerService
     */
    private $mailerService;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * OrderManager constructor.
     * @param SessionInterface $session
     * @param PriceManager $priceManager
     * @param PaymentService $paymentService
     * @param MailerService $mailerService
     * @param EntityManagerInterface $em
     */
    public function __construct(
        SessionInterface $session,
        PriceManager $priceManager,
        PaymentService $paymentService,
        MailerService $mailerService,
        EntityManagerInterface $em
    )
    {
        $this->session = $session;
        $this->paymentService = $paymentService;
        $this->priceManager = $priceManager;
        $this->mailerService = $mailerService;
        $this->em = $em;
    }

    /**
     * @return Order
     * @throws \Exception
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
    public function computePrice(Order $order)
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
        if ($order instanceof Order) {
            return $order;
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function doPayment(Order $order)
    {
        $referenceTransaction = $this->paymentService->doPayment(
            $order->getPrice(),
            "Votre commande de billet pour telle date"
        );
        // dump($referenceTransaction);die();
        if ($referenceTransaction) {
            $order->setBookingNumber($referenceTransaction);
            $this->em->persist($order);
            $this->em->flush();
            $this->mailerService->sendOrderConfirmation($order);
            return true;
        }
        return false;
    }
}