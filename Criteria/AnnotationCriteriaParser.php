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

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
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
            $annotation = $this->annotationReader->getPropertyAnnotation($property, $this->annotationClass);

            if ($annotation) {
                $annotations[$property->getName()] = $annotation;
            }
        }

        return $annotations;
    }
}
