<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 06/11/2018
 * Time: 15:13
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotTuesday extends Constraint
{
    public $message = "Vous ne pouvez pas sélectionner le mardi";
}