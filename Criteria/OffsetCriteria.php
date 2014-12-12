<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class OffsetCriteria implements CriteriaInterface
{
    /**
     * @var integer
     */
    private $offset;

    /**
     * @param integer $offset
     */
    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @inheritdoc
     */
    public function toDoctrineQueryBuilder(QueryBuilder $qb)
    {
        return $qb->setFirstResult($this->offset);
    }
}
