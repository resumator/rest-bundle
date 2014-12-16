<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\EqualsCriteria;

class EqualsCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asDoctrineTest()
    {
        $criteria = new EqualsCriteria('favoriteColor', 'blue');

        $qb = CriteriaQueryBuilderFactory::build($this);

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asDoctrine($qb, 'p');

        $this->assertSame('SELECT p FROM Lemon\RestBundle\Tests\Fixtures\Person p WHERE p.favoriteColor = :favoriteColor', $qb->getDQL());
        $this->assertSame(1, $qb->getParameters()->count());
        $this->assertSame('favoriteColor', $qb->getParameters()->get(0)->getName());
        $this->assertSame('blue', $qb->getParameters()->get(0)->getValue());
    }
}
