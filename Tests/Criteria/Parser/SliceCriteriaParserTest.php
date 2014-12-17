<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\Parser\SliceCriteriaParser;

class SliceCriteriaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function parseTest()
    {
        $scp = new SliceCriteriaParser();

        $criteria = $scp->parse(array('_limit' => 5, '_offset' => 5), 'person');

        $this->assertCount(2, $criteria);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\LimitCriteria', $criteria[0]);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\OffsetCriteria', $criteria[1]);
    }
}
