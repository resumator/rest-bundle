<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\Common\Annotations\AnnotationReader;
use Lemon\RestBundle\Object\Registry;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class EqualsCriteriaParser extends AnnotationCriteriaParser implements CriteriaParserInterface
{
    protected $annotationClass = 'Lemon\RestBundle\Annotation\Filterable';

    /**
     * @var RecursiveValidator
     */
    private $validator;

    /**
     * @var Registry
     */
    private $objectRegistry;

    /**
     * @param AnnotationReader $annotationReader
     * @param RecursiveValidator $validator
     * @param Registry $objectRegistry
     */
    public function __construct(
        AnnotationReader $annotationReader,
        RecursiveValidator $validator,
        Registry $objectRegistry)
    {
        $this->validator = $validator;
        $this->objectRegistry = $objectRegistry;

        parent::__construct($annotationReader);
    }

    /**
     * @inheritdoc
     */
    public function parse(array $query, $resource)
    {
        $criteria = array();

        $resourceClass = $this->objectRegistry->getClass($resource);

        $annotations = $this->getAnnotations($resourceClass);

        foreach (array_keys($annotations) as $property) {
            if (array_key_exists($property, $query) &&
                is_scalar($query[$property])) {
                $violations = $this->validator->validatePropertyValue($resourceClass, $property, $query[$property]);

                if (count($violations) === 0) {
                    $criteria[] = new EqualsCriteria($property, $query[$property]);
                }
            }
        }

        return $criteria;
    }
}
