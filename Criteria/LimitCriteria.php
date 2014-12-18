<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class LimitCriteria implements DoctrineCriteriaInterface
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
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @inheritdoc
     */
    public function asQueryBuilder(QueryBuilder $qb, $alias)
    {
        return $qb->setMaxResults($this->limit);
    }
}
