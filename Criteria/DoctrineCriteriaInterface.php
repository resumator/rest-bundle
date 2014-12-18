<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

interface DoctrineCriteriaInterface extends CriteriaInterface
{
    /**
     * @param QueryBuilder $qb
     * @param string $alias
     * @return QueryBuilder
     */
    public function asQueryBuilder(QueryBuilder $qb, $alias);
}
