<?php

namespace restapi\modules\v1\beans;

/**
 * 优惠结果类
 * Class DiscountResult
 * @package app\modules\v1\entities
 */
class DiscountResult {

    /**
     * @var boolean
     */
    public $isValid;

    /**
     * @var boolean
     */
    public $isShare;

    /**
     * @var string
     */
    public $description;

    /**
     * @var double
     */
    public $discountPrice;
}