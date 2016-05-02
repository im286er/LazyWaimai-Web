<?php

namespace restapi\modules\v1\beans;

/**
 * 优惠信息类
 */
class DiscountInfo {
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var double
     */
    public $price;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $iconName;

    /**
     * @var string
     */
    public $iconColor;

    /**
     * @var boolean
     */
    public $isShare;

    /**
     * @var int
     */
    public $priority;
}