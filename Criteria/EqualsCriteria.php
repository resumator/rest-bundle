<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class EqualsCriteria implements CriteriaInterface
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $value;

    /**
     * @param string $property
     * @param string $value
     */
    public function __construct($property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function toDoctrineQueryBuilder(QueryBuilder $qb)
    {
        return $qb->andWhere($qb->expr()->eq($this->property, $this->value));
    }
}
