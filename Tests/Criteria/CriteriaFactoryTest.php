<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\CriteriaFactory;
use Lemon\RestBundle\Criteria\SliceCriteriaParser;

class CriteriaFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CriteriaFactory
     */
    private $criteriaFactory;

    public function setUp()
    {
        $this->criteriaFactory = new CriteriaFactory();

        $this->criteriaFactory->addParser(new SliceCriteriaParser());
    }

    /**
     * @test
     */
    public function addParserTest()
    {
        $parsers = $this->criteriaFactory->getParsers();

        $this->assertCount(1, $parsers);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\SliceCriteriaParser', $parsers[0]);
    }

    /**
     * @test
     */
    public function buildTest()
    {
        $criteria = $this->criteriaFactory->create(array('_limit' => 5, '_offset' => 5), 'person');

        $this->assertCount(2, $criteria);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\CriteriaInterface', $criteria[0]);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\CriteriaInterface', $criteria[1]);
    }
}
