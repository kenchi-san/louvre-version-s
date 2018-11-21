<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 20/11/2018
 * Time: 15:19
 */

namespace AppBundle\Validator\Constraints;


use AppBundle\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class HalfDayValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
{

    $this->entityManager = $entityManager;
}

    /**
     * Checks if the passed value is valid.
     *
     * @param $objet
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($objet, Constraint $constraint)
    {
        $currentHour = date('H');
        $currentday = date("Y/m/d");

  /*  if ($dateLimite = $this->getDate()->add(new \DateInterval('P6M')))
        ;
        return $dateLimite->format('d-m-Y');
*/

        if ($currentHour > Order::HALF_DAY_HOUR_LIMIT
        // TODO l'utilisateura choisi la date d'aujourd'hui  &&
            // TODO l'utilisateur a choisi FULL_DAY


        ) {
//dump($currentday);die();
            /*$this->context->buildViolation($constraint->message)
                ->atPath('bookingDate')
                ->addViolation();*/
        }
    }
}