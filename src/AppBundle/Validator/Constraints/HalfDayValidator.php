<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 20/11/2018
 * Time: 15:19
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Order;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HalfDayValidator extends ConstraintValidator
{


    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param $order
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($order, Constraint $constraint)
    {
        $currentHour = date('H');
        $currentday = date("Y/m/d");

        if ($currentHour > Order::HALF_DAY_HOUR_LIMIT
        // TODO l'utilisateura choisi la date d'aujourd'hui  &&
            // TODO l'utilisateur a choisi FULL_DAY


        ) {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();
        }
    }
}