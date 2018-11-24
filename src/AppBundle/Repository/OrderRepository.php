<?php

namespace AppBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;

/**
 * OrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param \DateTime $date
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function countTicketSoldForDate(\DateTime $date)
    {
        $q = $this->createQueryBuilder('o')
            ->select('SUM(o.qteOrder)')
            ->where('o.bookingDate = :date')
            ->setParameter('date', $date)
            ->getQuery();

       $res =  $q->getSingleScalarResult();

       if(!$res){
           return 0;
       }

       return $res;
    }


}