<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

interface CriteriaInterface
{
    /**
     * @param QueryBuilder $qb
     * @param string $alias
     * @return QueryBuilder
     */
    public function asDoctrine(QueryBuilder $qb, $alias);
}
