<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class EqualsCriteria implements DoctrineCriteriaInterface, CollectionFilterCriteriaInterface
{
    /**
     * @var string
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $property
     * @param mixed $value
     */
    public function __construct($property, $value)
    {
        $this->property = $property;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function asQueryBuilder(QueryBuilder $qb, $alias)
    {
        return $qb
            ->andWhere($qb->expr()->eq("{$alias}.{$this->property}", ":{$this->property}"))
            ->setParameter(":{$this->property}", $this->value);
    }
}
