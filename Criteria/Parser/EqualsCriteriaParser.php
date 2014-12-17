<?php
namespace Lemon\RestBundle\Criteria\Parser;

use Lemon\RestBundle\Criteria\EqualsCriteria;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class EqualsCriteriaParser extends AnnotationCriteriaParser implements CriteriaParserInterface, ResourceClassAwareInterface
{
    protected $annotationClass = 'Lemon\RestBundle\Annotation\Filterable';

    /**
     * @var RecursiveValidator
     */
    private $validator;

    /**
     * @var string
     */
    private $resourceClass;

    /**
     * @param RecursiveValidator $validator
     */
    public function __construct(RecursiveValidator $validator)
    {
        $this->validator = $validator;

        parent::__construct();
    }

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

        $properties = $this->getFilterableProperties();

        foreach ($properties as $property) {
            if (array_key_exists($property, $query) &&
                is_scalar($query[$property]) &&
                $this->filterIsValid($property, $query[$property])) {
                $criteria[] = new EqualsCriteria($property, $query[$property]);
            }
        }

        return $criteria;
    }

    /**
     * @return array
     */
    protected function getFilterableProperties()
    {
        return $this->getAnnotatedProperties($this->resourceClass);
    }

    /**
     * @param string $property
     * @param mixed $value
     * @return boolean
     */
    protected function filterIsValid($property, $value)
    {
        return count($this->validator->validatePropertyValue($this->resourceClass, $property, $value)) === 0;
    }
}
