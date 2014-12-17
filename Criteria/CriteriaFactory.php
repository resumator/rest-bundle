<?php
namespace Lemon\RestBundle\Criteria;

use Lemon\RestBundle\Object\Registry;

class CriteriaFactory
{
    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var array
     */
    private $criteriaParsers;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
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
    public function create(array $query, $resource)
    {
        $criteria = array();

        /** @var CriteriaParserInterface|ResourceClassAwareInterface $parser */
        foreach ($this->getParsers() as $parser) {
            if ($parser instanceof ResourceClassAwareInterface) {
                $parser->setResourceClass($this->registry->getClass($resource));
            }

            $criteria = array_merge($criteria, $parser->parse($query, $resource));
        }

        return $criteria;
    }
}
