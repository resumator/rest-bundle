<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class LimitCriteria implements CriteriaInterface
{
    /**
     * @var integer
     */
    private $limit;

    /**
     * @param integer $limit
     */
    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @inheritdoc
     */
    public function toDoctrineQueryBuilder(QueryBuilder $qb)
    {
        return $qb->setMaxResults($this->limit);
    }
}
