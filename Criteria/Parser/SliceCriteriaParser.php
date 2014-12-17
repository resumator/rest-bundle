<?php
namespace Lemon\RestBundle\Criteria\Parser;

use Lemon\RestBundle\Criteria\LimitCriteria;
use Lemon\RestBundle\Criteria\OffsetCriteria;

class SliceCriteriaParser implements CriteriaParserInterface
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
     * @var integer
     */
    protected $defaultLimit = 25;

    /**
     * @var integer
     */
    protected $defaultOffset = 0;

    /**
     * @inheritdoc
     */
    public function parse(array $query)
    {
        $criteria = array();

        $limit = $this->defaultLimit;

        if (array_key_exists($this->limitParamName, $query) &&
            is_int($query[$this->limitParamName])) {
            $limit = (int)$query[$this->limitParamName];
        }

        $criteria[] = new LimitCriteria($limit);

        $offset = $this->defaultOffset;

        if (array_key_exists($this->offsetParamName, $query) &&
            is_int($query[$this->offsetParamName])) {
            $offset = (int)$query[$this->offsetParamName];
        }

        $criteria[] = new OffsetCriteria($offset);

        return $criteria;
    }
}
