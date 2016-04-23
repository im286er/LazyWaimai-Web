<?php

namespace restapi\modules\v1\models;

/**
 * 选购的商品类
 */
class BoughtProduct {
    /**
     * 商品ID
     * @var int
     */
    private $id;
    /**
     * 商品名
     * @var string
     */
    private $name;
    /**
     * 商品单价
     * @var integer
     */
    private $unitPrice;
    /** 商品总价
     * @var integer
     */
    private $totalPrice;
    /**
     * 商品分类ID
     * @var int
     */
    private $categoryId;
    /**
     * 选购的商品数量
     * @var int
     */
    private $quantity;
    /**
     * 商品库存
     * @var int
     */
    private $leftNum;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getUnitPrice() {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     */
    public function setUnitPrice($unitPrice) {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return int
     */
    public function getTotalPrice() {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     */
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return int
     */
    public function getCategoryId() {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    /**
     * @return int
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getLeftNum() {
        return $this->leftNum;
    }

    /**
     * @param int $leftNum
     */
    public function setLeftNum($leftNum) {
        $this->leftNum = $leftNum;
    }
}