<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 14/11/2018
 * Time: 00:37
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotSundayValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$constraint instanceof NotSunday){
            return;
        }


        if($value->format('w') == 0){
            $this->context->addViolation($constraint->message);
        }
    }
}