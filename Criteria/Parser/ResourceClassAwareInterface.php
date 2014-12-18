<?php
namespace Lemon\RestBundle\Criteria\Parser;

interface ResourceClassAwareInterface
{
    /**
     * @param string $class
     */
    public function setResourceClass($class);
}
