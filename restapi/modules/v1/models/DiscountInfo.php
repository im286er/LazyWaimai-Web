<?php

namespace restapi\modules\v1\models;

/**
 * 优惠信息类
 * Class DiscountInfo
 * @package app\modules\v1\models
 */
class DiscountInfo {
    public $id;
    public $name;
    public $description;
    public $price;
    public $code;
    public $attribute;
    public $iconName;
    public $iconColor;
    public $isShare;
    public $priority;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param mixed $attribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @return mixed
     */
    public function getIconName()
    {
        return $this->iconName;
    }

    /**
     * @param mixed $iconName
     */
    public function setIconName($iconName)
    {
        $this->iconName = $iconName;
    }

    /**
     * @return mixed
     */
    public function getIconColor()
    {
        return $this->iconColor;
    }

    /**
     * @param mixed $iconColor
     */
    public function setIconColor($iconColor)
    {
        $this->iconColor = $iconColor;
    }

    /**
     * @return mixed
     */
    public function getIsShare()
    {
        return $this->isShare;
    }

    /**
     * @param mixed $isShare
     */
    public function setIsShare($isShare)
    {
        $this->isShare = $isShare;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}