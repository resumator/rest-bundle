<?php
namespace Lemon\RestBundle\Criteria;

class SliceCriteriaParser extends AnnotationCriteriaParser implements CriteriaParserInterface
{
    /**
     * @var string
     */
    protected $limitParamName = '_limit';

    /**
     * @var string
     */
    protected $offsetParamName = '_offset';

    /**
     * @inheritdoc
     */
    public function parse(array $query, $resource)
    {
        $criteria = array();

        if (array_key_exists($this->limitParamName, $query) &&
            is_int($query[$this->limitParamName])) {
            $criteria[] = new LimitCriteria((int)$query[$this->limitParamName]);
        }

        if (array_key_exists($this->offsetParamName, $query) &&
            is_int($query[$this->offsetParamName])) {
            $criteria[] = new OffsetCriteria((int)$query[$this->offsetParamName]);
        }

        return $criteria;
    }
}
