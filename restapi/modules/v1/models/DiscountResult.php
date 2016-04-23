<?php

namespace restapi\modules\v1\models;

/**
 * 优惠结果类
 * Class DiscountResult
 * @package app\modules\v1\entities
 */
class DiscountResult {
    private $isValid = false;
    private $isShare = false;
    private $description = '';
    private $discountPrice = 0;

    /**
     * @return int
     */
    public function getDiscountPrice()
    {
        return $this->discountPrice;
    }

    /**
     * @param int $discountPrice
     */
    public function setDiscountPrice($discountPrice)
    {
        $this->discountPrice = $discountPrice;
    }

    /**
     * @return boolean
     */
    public function isIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param boolean $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * @return boolean
     */
    public function isIsShare()
    {
        return $this->isShare;
    }

    /**
     * @param boolean $isShare
     */
    public function setIsShare($isShare)
    {
        $this->isShare = $isShare;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    function __toString()
    {
        return '[isValid:'.$this->isValid.', '
        .'isShare:'.$this->isShare.', '
        .'discountPrice:'.$this->discountPrice.', '
        .'description:'.$this->description.']';
    }


}