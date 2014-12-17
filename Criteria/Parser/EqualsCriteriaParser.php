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
    public function parse(array $query, $resource)
    {
        $criteria = array();

        $annotations = $this->getAnnotations($this->resourceClass);

        foreach (array_keys($annotations) as $property) {
            if (array_key_exists($property, $query) &&
                is_scalar($query[$property])) {
                $violations = $this->validator->validatePropertyValue($this->resourceClass, $property, $query[$property]);

                if (count($violations) === 0) {
                    $criteria[] = new EqualsCriteria($property, $query[$property]);
                }
            }
        }

        return $criteria;
    }
}
