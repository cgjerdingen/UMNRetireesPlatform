<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PersonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PersonRepository extends EntityRepository
{
    public function findBySearchTerms($searchTerms, $page = 1, $limit = 10) {
        $dql = "SELECT p.id, p.fullname FROM UMRAMemberBundle:Person p WHERE p.fullname LIKE :terms OR p.firstname LIKE :terms OR p.lastname LIKE :terms";

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter("terms", '%'.$searchTerms.'%')
            ->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit)
            ->getArrayResult();
    }
}