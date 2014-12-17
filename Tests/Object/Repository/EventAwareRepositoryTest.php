<?php

namespace Lemon\RestBundle\Tests\Object\Repository;

use Lemon\RestBundle\Object\Repository\DoctrineRepository;
use Lemon\RestBundle\Object\Repository\EventAwareRepository;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventAwareRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $ed = new EventDispatcher();

        $ear = new EventAwareRepository($dr, $ed);

        $class = 'foo';

        $ear->setClass($class);

        $this->assertEquals($class, $ear->getClass());
        $this->assertEquals($dr, $ear->getRepository());
        $this->assertEquals($ed, $ear->getEventDispatcher());
    }
}
