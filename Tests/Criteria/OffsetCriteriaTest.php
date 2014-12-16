<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\OffsetCriteria;

class OffsetCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asDoctrineTest()
    {
        $criteria = new OffsetCriteria(1234);

        $qb = CriteriaQueryBuilderFactory::build($this);

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asDoctrine($qb, 'p');

        $this->assertSame(1234, $qb->getFirstResult());
    }
}
