<?php
namespace Lemon\RestBundle\Criteria;

use Doctrine\Common\Annotations\AnnotationReader;

abstract class AnnotationCriteriaParser
{
    /**
     * @var string
     */
    protected $annotationClass;

    /**
     * @var AnnotationReader
     */
    private $annotationReader;

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param string $resourceClass
     * @return array
     */
    public function getAnnotations($resourceClass)
    {
        $klass = new \ReflectionClass($resourceClass);

        $properties = $klass->getProperties();

        $annotations = array();

        foreach ($properties as $property) {
            $annotations[$property->getName()] = $this->annotationReader->getPropertyAnnotations($property, $this->annotationClass);
        }

        return $annotations;
    }
}