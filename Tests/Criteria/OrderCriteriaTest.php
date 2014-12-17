<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\OrderCriteria;
use Lemon\RestBundle\Criteria\OrderDirection;

class OrderCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asDoctrineTest()
    {
        $criteria = new OrderCriteria('favoriteColor', new OrderDirection());

        $qb = CriteriaQueryBuilderFactory::build($this);

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asDoctrine($qb, 'p');

        $this->assertSame('SELECT p FROM Lemon\RestBundle\Tests\Fixtures\Person p ORDER BY p.favoriteColor ASC', $qb->getDQL());
    }

    /**
     * @test
     */
    public function getterTest()
    {
        $criteria = new OrderCriteria('favoriteColor', new OrderDirection());

        $this->assertEquals('favoriteColor', $criteria->getField());
        $this->assertTrue(OrderDirection::Ascending == $criteria->getDirection());
    }
}
