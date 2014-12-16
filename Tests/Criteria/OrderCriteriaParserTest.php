<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\OrderCriteriaParser;
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

        $this->assertCount(1, $criteria);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\OrderCriteria', $criteria[0]);
    }

    /**
     * @test
     */
    public function parseValidationFailedTest()
    {
        $ocp = new OrderCriteriaParser($this->objectRegistry);

        $criteria = $ocp->parse(array('_orderBy' => 'favoriteColor', '_orderDir' => 'DESC'), 'person');

        $this->assertCount(0, $criteria);
    }
}
