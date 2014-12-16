<?php
namespace Lemon\RestBundle\Criteria;

class CriteriaFactory
{
    /**
     * @var array
     */
    private $criteriaParsers;

    public function __construct()
    {
        $this->criteriaParsers = array();
    }

    /**
     * @param CriteriaParserInterface $parser
     */
    public function addParser(CriteriaParserInterface $parser)
    {
        $this->criteriaParsers[] = $parser;
    }

    /**
     * @return array
     */
    public function getParsers()
    {
        return $this->criteriaParsers;
    }

    /**
     * @param array $query
     * @param string $resource
     * @return array
     */
    public function build(array $query, $resource)
    {
        $criteria = array();

        /** @var CriteriaParserInterface $parser */
        foreach ($this->getParsers() as $parser) {
            $criteria  = array_merge($criteria, $parser->parse($query, $resource));
        }

        return $criteria;
    }
}
