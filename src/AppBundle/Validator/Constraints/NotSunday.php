<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 14/11/2018
 * Time: 00:37
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 */
class NotSunday extends Constraint
{
public $message="Le musée est fermé le dimanche";
}