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

    public function build(array $query, $resource)
    {
        $criteria = array();

        /** @var CriteriaParserInterface $parser */
        foreach ($this->criteriaParsers as $parser) {
            $criteria  = array_merge($criteria, $parser->parse($query, $resource));
        }

        return $criteria;
    }
}
