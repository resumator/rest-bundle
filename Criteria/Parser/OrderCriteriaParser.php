<?php
namespace Lemon\RestBundle\Criteria\Parser;

use Lemon\RestBundle\Criteria\OrderCriteria;
use Lemon\RestBundle\Criteria\OrderDirection;

class OrderCriteriaParser extends AnnotationCriteriaParser implements CriteriaParserInterface, ResourceClassAwareInterface
{
    protected $annotationClass = 'Lemon\RestBundle\Annotation\Sortable';

    /**
     * @var string
     */
    private $resourceClass;

    /**
     * @var string
     */
    protected $orderFieldParamName = '_orderBy';

    /**
     * @var string
     */
    protected $orderDirectionParamName = '_orderDir';

    /**
     * @inheritdoc
     */
    public function setResourceClass($resourceClass)
    {
        $this->resourceClass = $resourceClass;
    }

    /**
     * @inheritdoc
     */
    public function parse(array $query)
    {
        $criteria = array();

        $properties = $this->getSortableProperties();

        if (array_key_exists($this->orderFieldParamName, $query) &&
            in_array($query[$this->orderFieldParamName], $properties)) {
            $orderDirection = new OrderDirection();

            if (array_key_exists($this->orderDirectionParamName, $query) &&
                in_array($query[$this->orderDirectionParamName], $orderDirection->getConstList())) {
                $orderDirection = new OrderDirection($query[$this->orderDirectionParamName]);
            }

            $criteria[] = new OrderCriteria($query[$this->orderFieldParamName], $orderDirection);
        }

        return $criteria;
    }

    /**
     * @return array
     */
    protected function getSortableProperties()
    {
        return $this->getAnnotatedProperties($this->resourceClass);
    }
}
