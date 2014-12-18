<?php

namespace Lemon\RestBundle\Tests\Object\Repository;

use Lemon\RestBundle\Object\Repository\DoctrineRepository;

class DoctrineRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function setterAndGetterTest()
    {
        /** @var \Doctrine\Bundle\DoctrineBundle\Registry $doctrine */
        $doctrine = $this
            ->getMockBuilder('Doctrine\Bundle\DoctrineBundle\Registry')
            ->disableOriginalConstructor()
            ->getMock();

        $dr = new DoctrineRepository($doctrine);

        $class = 'foo';

        $dr->setClass($class);

        $this->assertEquals($class, $dr->getClass());
    }
}
