<?php
namespace Lemon\RestBundle\Criteria\Parser;

interface CriteriaParserInterface
{
    /**
     * @param array $query
     * @param string $resource
     * @return array
     */
    public function parse(array $query, $resource);
}
