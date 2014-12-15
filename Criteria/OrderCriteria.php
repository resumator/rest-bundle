<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class OrderCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var OrderDirection
     */
    private $direction;

    /**
     * @param string $field
     * @param OrderDirection $direction
     */
    public function __construct($field, OrderDirection $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    /**
     * @inheritdoc
     */
    public function asDoctrine(QueryBuilder $qb, $alias)
    {
        return $qb->orderBy("{$alias}.{$this->field}", $this->direction);
    }

    /**
     * @inheritdoc
     */
    public function isCollectionFilter()
    {
        return false;
    }
}
