<?php
namespace Lemon\RestBundle\Criteria\Parser;

interface CriteriaParserInterface
{
    /**
     * @param array $query
     * @return array
     */
    public function parse(array $query);
}
