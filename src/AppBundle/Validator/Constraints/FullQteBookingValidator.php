<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 13/11/2018
 * Time: 15:14
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FullQteBookingValidator extends ConstraintValidator
{
    public function __construct()
    {

        /// COMMENT FAIRE POUR INJECTER ENTITY MANAGER et donc recuperer OrderRepositoyr
    }


    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($order, Constraint $constraint)
    {

        //$this->orderReposotory.....
        if ($order->getQteOrder() == 5) {
            $this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();
        }
    }
}