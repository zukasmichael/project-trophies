<?php

namespace Svnfqt\ProjectTrophies\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class TrophyRepository extends DocumentRepository
{
    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder()
            ->field('users')->prime(true)
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();
    }
}
