<?php
namespace Lemon\RestBundle\Criteria;

use Symfony\Component\HttpFoundation\Request;

interface CriteriaParserInterface
{
    /**
     * @param array $query
     * @param string $resource
     * @return array
     */
    public function parse(array $query, $resource);
}
