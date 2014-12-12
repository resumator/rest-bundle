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
    public function toDoctrineQueryBuilder(QueryBuilder $qb)
    {
        return $qb->orderBy($this->field, $this->direction);
    }
}

class OrderDirection extends \SplEnum
{
    const __default = self::Ascending;

    const Ascending = 'ASC';
    const Descending = 'DESC';
}
