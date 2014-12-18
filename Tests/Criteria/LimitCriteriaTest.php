<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\LimitCriteria;

class LimitCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asQueryBuilderTest()
    {
        $criteria = new LimitCriteria(999);

        $qb = CriteriaQueryBuilderFactory::build($this);

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asQueryBuilder($qb, 'p');

        $this->assertSame(999, $qb->getMaxResults());
    }

    /**
     * @test
     */
    public function getterTest()
    {
        $criteria = new LimitCriteria(999);

        $this->assertEquals(999, $criteria->getLimit());
    }
}
