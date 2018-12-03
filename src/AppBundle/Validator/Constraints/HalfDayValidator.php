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
        $createdAt = $order->getBookingDate()->format("Y/m/d");
        $typeOrder = $order->getTypeOrder();

        if ($currentday === $createdAt &&
            $currentHour > Order::HALF_DAY_HOUR_LIMIT &&
            $typeOrder === Order::TYPE_FULL_DAY
        ) {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();
        }
    }
}