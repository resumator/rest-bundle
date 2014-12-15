<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class EqualsCriteria implements CriteriaInterface, CollectionFilterCriteriaInterface
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
    public function asDoctrine(QueryBuilder $qb, $alias)
    {
        return $qb
            ->andWhere($qb->expr()->eq("{$alias}.{$this->property}", ":{$this->property}"))
            ->setParameter(":{$this->property}", $this->value);
    }
}
