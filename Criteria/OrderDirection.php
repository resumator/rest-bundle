<?php

namespace Lemon\RestBundle\Criteria;

class OrderDirection extends \SplEnum
{
    const __default = self::Ascending;

    const Ascending = 'ASC';
    const Descending = 'DESC';
}
