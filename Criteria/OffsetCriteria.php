<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\ORM\QueryBuilder;

class OffsetCriteria implements DoctrineCriteriaInterface
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
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @inheritdoc
     */
    public function asQueryBuilder(QueryBuilder $qb, $alias)
    {
        return $qb->setFirstResult($this->offset);
    }
}
