<?php

namespace Lemon\RestBundle\Tests\Criteria\Parser;

use Lemon\RestBundle\Criteria\Parser\EqualsCriteriaParser;
use Symfony\Component\Validator\ValidatorBuilder;

class EqualsCriteriaParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Validator\Validator\RecursiveValidator
     */
    private $validator;

    /**
     * @var Registry
     */
    private $objectRegistry;

    public function setUp()
    {
        $vb = new ValidatorBuilder();
        $vb->enableAnnotationMapping();
        $this->validator = $vb->getValidator();
    }

    /**
     * @test
     */
    public function parseTest()
    {
        $ecp = new EqualsCriteriaParser($this->validator, $this->objectRegistry);

        $ecp->setResourceClass('Lemon\RestBundle\Tests\Fixtures\Person');

        $criteria = $ecp->parse(array('name' => 'John Doe'));

        $this->assertCount(1, $criteria);
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\EqualsCriteria', $criteria[0]);
    }

    /**
     * @test
     */
    public function parseValidationFailedTest()
    {
        $ecp = new EqualsCriteriaParser($this->validator, $this->objectRegistry);

        $ecp->setResourceClass('Lemon\RestBundle\Tests\Fixtures\Person');

        $criteria = $ecp->parse(array('name' => 'This is a string that is greater than 20 characters.'));

        $this->assertCount(0, $criteria);
    }
}
