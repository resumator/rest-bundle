<?php
namespace Lemon\RestBundle\Criteria;

interface ResourceClassAwareInterface
{
    /**
     * @param string $class
     */
    public function setResourceClass($class);
}