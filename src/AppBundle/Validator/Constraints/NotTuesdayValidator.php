<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 06/11/2018
 * Time: 15:17
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotTuesdayValidator extends ConstraintValidator
{

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if(!$constraint instanceof NotTuesday){
            return;
        }


        if($value->format('w') == 2){
            $this->context->addViolation($constraint->message);
        }
    }
}