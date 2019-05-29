<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 13/11/2018
 * Time: 15:14
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Order;
use AppBundle\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullQteBookingValidator extends ConstraintValidator
{

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->orderRepository = $em->getRepository(Order::class);
    }


    /**
     * Checks if the passed value is valid.
     *
     * @param $order
     * @param Constraint $constraint The constraint for the validation
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($order, Constraint $constraint)
    {

        if(!$order instanceof  Order){
            return ;
        }

        $nbTicketSold = $this->orderRepository->countTicketSoldForDate($order->getBookingDate());

        if ((Order::MAX_TICKET_PER_DAY - $nbTicketSold) < $order->getQteOrder()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();
        }
    }


}