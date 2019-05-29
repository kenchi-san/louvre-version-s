<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 08/11/2018
 * Time: 16:12
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PublicHoliday extends Constraint
{
    public $message = "Vous ne pouvez pas selectioner un jour férié";
}