<?php
namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * HouseholdRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LuncheonRepository extends EntityRepository
{
    public function findLatestLuncheons($count = 7, $onlyOpen = true, $fromDate = null)
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('l')
            ->from('UMRAMemberBundle:Luncheon', 'l');

        if ($onlyOpen) {
            $qb = $qb->where('l.registrationOpen = 1');
        }

        if ($fromDate instanceof \DateTime) {
            $qb = $qb->andWhere('l.luncheonDate >= :from_date')
                     ->setParameter('from_date', $fromDate);
        }

        return $qb->orderBy('l.luncheonDate', 'ASC')
                  ->setMaxResults($count)
                  ->getQuery()
                  ->getResult();
    }
}