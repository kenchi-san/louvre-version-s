<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 13/11/2018
 * Time: 15:11
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class FullQteBooking extends Constraint
{
    public $message = "Nous avons plus de place pour ce jour";

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }


}