<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Doctrine\DBAL\Query\Expression\ExpressionBuilder;

class CriteriaQueryBuilderFactory
{
    /**
     * @param \PHPUnit_Framework_TestCase $testCase
     * @return \Doctrine\ORM\QueryBuilder
     */
    public static function build(\PHPUnit_Framework_TestCase $testCase)
    {
        /** @var \Doctrine\DBAL\Connection $connection */
        $connection = $testCase
            ->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $eb = new ExpressionBuilder($connection);

        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $testCase
            ->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->setConstructorArgs(
                array(
                    $testCase
                        ->getMockBuilder('Doctrine\ORM\EntityManager')
                        ->disableOriginalConstructor()
                        ->getMock()
                )
            )
            ->setMethods(['expr'])
            ->getMock();

        $qb
            ->expects($testCase->any())
            ->method('expr')
            ->will($testCase->returnValue($eb));

        return $qb;
    }
}
