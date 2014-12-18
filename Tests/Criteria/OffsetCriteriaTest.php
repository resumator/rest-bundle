<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\OffsetCriteria;

class OffsetCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asQueryBuilderTest()
    {
        $criteria = new OffsetCriteria(1234);

        $qb = CriteriaQueryBuilderFactory::build($this);

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asQueryBuilder($qb, 'p');

        $this->assertSame(1234, $qb->getFirstResult());
    }

    /**
     * @test
     */
    public function getterTest()
    {
        $criteria = new OffsetCriteria(1234);

        $this->assertEquals(1234, $criteria->getOffset());
    }
}
