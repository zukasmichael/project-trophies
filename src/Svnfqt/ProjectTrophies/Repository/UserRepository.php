<?php

namespace Svnfqt\ProjectTrophies\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class UserRepository extends DocumentRepository
{
    public function findAllOrderedByUsername()
    {
        return $this->createQueryBuilder()
            ->sort('username', 'ASC')
            ->getQuery()
            ->execute();
    }
}
