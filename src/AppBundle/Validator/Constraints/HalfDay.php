<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 20/11/2018
 * Time: 15:18
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 *
 * @Annotation
 *
 */
class HalfDay extends Constraint
{
    public $message = 'Vous ne pouvez pas réserver pour une journée entière après 14h ';

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}