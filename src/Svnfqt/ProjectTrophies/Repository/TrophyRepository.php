<?php

namespace Svnfqt\ProjectTrophies\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class TrophyRepository extends DocumentRepository
{
    public function findAllOrderedByName()
    {
        return $this->createQueryBuilder()
            ->sort('name', 'ASC')
            ->getQuery()
            ->execute();
    }
}
