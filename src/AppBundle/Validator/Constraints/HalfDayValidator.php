<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 20/11/2018
 * Time: 15:19
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HalfDayValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param $order
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($order, Constraint $constraint)
    {
        if (!$order instanceof Order) {
            return;
        }
        $currentHour = date('H');
        $currentday = date("Y/m/d");
        $CreatedAt = $order->getBookingDate()->format("Y/m/d");
        $TypeOrder = $order->getTypeOrder();

        if ($currentday === $CreatedAt && $currentHour > Order::HALF_DAY_HOUR_LIMIT && $TypeOrder === "jour plein"


        ) {

            $this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();
        }
    }
}