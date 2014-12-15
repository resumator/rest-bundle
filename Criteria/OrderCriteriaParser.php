<?php
namespace Lemon\RestBundle\Criteria;

use Lemon\RestBundle\Object\Registry;

class OrderCriteriaParser extends AnnotationCriteriaParser implements CriteriaParserInterface
{
    protected $annotationClass = 'Lemon\RestBundle\Annotation\Sortable';

    /**
     * @var Registry
     */
    private $objectRegistry;

    /**
     * @param Registry $objectRegistry
     */
    public function __construct(Registry $objectRegistry)
    {
        $this->objectRegistry = $objectRegistry;

        parent::__construct();
    }

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
    public function parse(array $query, $resource)
    {
        $criteria = array();

        $annotations = $this->getAnnotations($this->objectRegistry->getClass($resource));

        if (array_key_exists($this->orderFieldParamName, $query) &&
            array_key_exists($query[$this->orderFieldParamName], $annotations)) {
            $orderDirection = new OrderDirection();

            if (array_key_exists($this->orderDirectionParamName, $query) &&
                in_array($query[$this->orderDirectionParamName], $orderDirection->getConstList())) {
                $orderDirection = new OrderDirection($query[$this->orderDirectionParamName]);
            }

            $criteria[] = new OrderCriteria($query[$this->orderFieldParamName], $orderDirection);
        }

        return $criteria;
    }
}
