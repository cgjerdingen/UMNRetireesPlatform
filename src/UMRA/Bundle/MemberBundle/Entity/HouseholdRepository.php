<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * HouseholdRepository
 */
class HouseholdRepository extends EntityRepository
{
    public function queryBuilderFindByName($qb, $searchTerms)
    {
        $likeTerms = '%'.$searchTerms.'%';

        return $qb->andWhere(
                        $qb->expr()->orX(
                            $qb->expr()->like('h.firstname', ':terms'),
                            $qb->expr()->like('h.lastname', ':terms'),
                            $qb->expr()->like('h.postalname', ':terms')
                        )
                    )
                ->setParameter('terms', $likeTerms)
        ;
    }

    public function queryBuilderFindByActive($qb, $active)
    {
        return $qb->innerJoin('h.persons', 'p')
                  ->andWhere('p.activenow = :active')
                  ->setParameter('active', (int) $active);
    }

    public function queryBuilderFindRecentTransactions($qb)
    {
        return $qb->innerJoin('h.persons', 'p')
                  ->innerJoin('p.transactions', 't')
                  ->andWhere('t.trandate > :last_month')
                  ->setParameter('last_month', new \DateTime("last month"));
    }
}
