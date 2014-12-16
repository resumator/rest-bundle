<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Lemon\RestBundle\Criteria\EqualsCriteria;

class EqualsCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function asDoctrineTest()
    {
        $criteria = new EqualsCriteria('favoriteColor', 'blue');

        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $this
            ->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $eb = new ExpressionBuilder($connection);

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $this
            ->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->setConstructorArgs(
                array(
                    $this
                        ->getMockBuilder('Doctrine\ORM\EntityManager')
                        ->disableOriginalConstructor()
                        ->getMock()
                )
            )
            ->setMethods(['expr'])
            ->getMock();

        $qb
            ->expects($this->any())
            ->method('expr')
            ->will($this->returnValue($eb));

        $qb->select('p')->from('Lemon\RestBundle\Tests\Fixtures\Person', 'p');

        $criteria->asDoctrine($qb, 'p');

        $this->assertSame('SELECT p FROM Lemon\RestBundle\Tests\Fixtures\Person p WHERE p.favoriteColor = :favoriteColor', $qb->getDQL());
        $this->assertSame(1, $qb->getParameters()->count());
        $this->assertSame('favoriteColor', $qb->getParameters()->get(0)->getName());
        $this->assertSame('blue', $qb->getParameters()->get(0)->getValue());
    }
}
