<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TransRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TransRepository extends EntityRepository
{
    public function queryAll()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb
            ->select('t')
            ->from('UMRAMemberBundle:Trans', 't')
            ->orderBy('t.trandate', 'DESC')
            ->getQuery();
    }

    public function findLatestLuncheonFees($person, $count = 5)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb
            ->select('t')
            ->from('UMRAMemberBundle:Trans', 't')
            ->where($qb->expr()->eq('t.trantype', ':luncheonFee'))
            ->andWhere('t.person = :personId')
            ->setParameter('luncheonFee', "LUNCHEON_FEE")
            ->setParameter('personId', $person->getId())
            ->orderBy('t.trandate', 'DESC')
            ->setMaxResults((int) $count)
            ->getQuery()
            ->getResult();
    }

    public function findLatestMembershipFees($person, $count = 5)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        return $qb
            ->select('t')
            ->from('UMRAMemberBundle:Trans', 't')
            ->where($qb->expr()->orX(
                    $qb->expr()->eq('t.trantype', ':membershipNew'),
                    $qb->expr()->eq('t.trantype', ':membershipRenew')
            ))
            ->andWhere('t.person = :personId')
            ->setParameter('membershipNew', "MEMBERSHIP_NEW")
            ->setParameter('membershipRenew', "MEMBERSHIP_RENEW")
            ->setParameter('personId', $person->getId())
            ->orderBy('t.trandate', 'DESC')
            ->setMaxResults((int) $count)
            ->getQuery()
            ->getResult();
    }
}
