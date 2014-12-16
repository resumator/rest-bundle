<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\OrderCriteriaParser;
use Lemon\RestBundle\Criteria\OrderDirection;
use Lemon\RestBundle\Object\Registry;

class OrderCriteriaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Registry
     */
    private $objectRegistry;

    public function setUp()
    {
        $this->objectRegistry = new Registry();
        $this->objectRegistry->addClass('person', 'Lemon\RestBundle\Tests\Fixtures\Person');
    }

    /**
     * @test
     */
    public function parseTest()
    {
        $ocp = new OrderCriteriaParser($this->objectRegistry);

        $criteria = $ocp->parse(array('_orderBy' => 'name', '_orderDir' => 'ASC'), 'person');

        $this->assertSame(1, count($criteria));
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\OrderCriteria', $criteria[0]);

        /** @var \Lemon\RestBundle\Criteria\OrderCriteria $criterion */
        $criterion = $criteria[0];

        $this->assertSame('name', $criterion->getField());
        $this->assertTrue(OrderDirection::Ascending == $criterion->getDirection());
    }

    /**
     * @test
     */
    public function parseValidationFailedTest()
    {
        $ocp = new OrderCriteriaParser($this->objectRegistry);

        $criteria = $ocp->parse(array('_orderBy' => 'favoriteColor', '_orderDir' => 'DESC'), 'person');

        $this->assertSame(0, count($criteria));
    }
}
