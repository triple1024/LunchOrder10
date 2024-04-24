<?php

namespace App\Constants;

class Common
{
    const FOOD_ADD = '1';
    const FOOD_REDUCE = '2';

    const FOOD_LIST = [
        'add' => self::FOOD_ADD,
        'reduce' => self::FOOD_REDUCE
    ];

    const ORDER_RECOMMEND = '0';
    const ORDER_LATER = '1';
    const ORDER_OLDER = '2';

    const SORT_ORDER = [
        'recommend' => self::ORDER_RECOMMEND,
        'later' => self::ORDER_LATER,
        'older' => self::ORDER_OLDER
    ];
}