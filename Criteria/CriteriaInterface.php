<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

interface CriteriaInterface
{
    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function toDoctrineQueryBuilder(QueryBuilder $qb);
}
