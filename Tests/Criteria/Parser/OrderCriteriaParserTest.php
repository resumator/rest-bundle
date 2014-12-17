<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\Parser\OrderCriteriaParser;

class OrderCriteriaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function parseTest()
    {
        $ocp = new OrderCriteriaParser();

        $ocp->setResourceClass('Lemon\RestBundle\Tests\Fixtures\Person');

        $criteria = $ocp->parse(array('_orderBy' => 'name', '_orderDir' => 'ASC'));

        $this->assertCount(1, $criteria);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\OrderCriteria', $criteria[0]);
    }

    /**
     * @test
     */
    public function parseValidationFailedTest()
    {
        $ocp = new OrderCriteriaParser();

        $ocp->setResourceClass('Lemon\RestBundle\Tests\Fixtures\Person');

        $criteria = $ocp->parse(array('_orderBy' => 'favoriteColor', '_orderDir' => 'DESC'));

        $this->assertCount(0, $criteria);
    }
}
