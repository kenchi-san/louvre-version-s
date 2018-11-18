<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 08/11/2018
 * Time: 16:21
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class PublicHolidayValidator extends ConstraintValidator
{


    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$value instanceof \DateTime) {
            $value = new \DateTime($value);
        }

        $holiday = $this->getHolidays();

        if (in_array($value->format('m/d/Y'), $holiday)) {
            $this->context->addViolation($constraint->message);

        }
    }

    /**
     * @param null $year
     * @return array
     */
    function getHolidays($year = null)
    {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        $easterDate = easter_date($year);
        $easterDay = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear = date('Y', $easterDate);

        $holidays = [
            date("m/d/Y", mktime(0, 0, 0, 1, 1, $year)),
            date("m/d/Y", mktime(0, 0, 0, 5, 8, $year)),
            date("m/d/Y", mktime(0, 0, 0, 7, 14, $year)),
            date("m/d/Y", mktime(0, 0, 0, 8, 15, $year)),
            date("m/d/Y", mktime(0, 0, 0, 11, 11, $year)),
            date("m/d/Y", mktime(0, 0, 0, $easterMonth, $easterDay + 1, $easterYear)),
            date("m/d/Y", mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear)),
            date("m/d/Y", mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear)),
        ];

        return $holidays;

    }
}