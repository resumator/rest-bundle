<?php

namespace Lemon\RestBundle\Tests\Criteria;

use Lemon\RestBundle\Criteria\EqualsCriteriaParser;
use Lemon\RestBundle\Object\Registry;
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

        $this->objectRegistry = new Registry();
        $this->objectRegistry->addClass('person', 'Lemon\RestBundle\Tests\Fixtures\Person');
    }

    /**
     * @test
     */
    public function parseTest()
    {
        $ecp = new EqualsCriteriaParser($this->validator, $this->objectRegistry);

        $criteria = $ecp->parse(array('name' => 'John Doe'), 'person');

        $this->assertSame(1, count($criteria));
        $this->assertInstanceOf('Lemon\RestBundle\Criteria\EqualsCriteria', $criteria[0]);

        /** @var \Lemon\RestBundle\Criteria\EqualsCriteria $criterion */
        $criterion = $criteria[0];

        $this->assertSame('name', $criterion->getProperty());
        $this->assertSame('John Doe', $criterion->getValue());
    }

    /**
     * @test
     */
    public function parseValidationFailedTest()
    {
        $ecp = new EqualsCriteriaParser($this->validator, $this->objectRegistry);

        $criteria = $ecp->parse(array('name' => 'This is a string that is greater than 20 characters.'), 'person');

        $this->assertSame(0, count($criteria));
    }
}
