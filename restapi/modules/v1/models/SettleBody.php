<?php

namespace restapi\modules\v1\models;

class SettleBody {
    /**
     * 商铺ID
     * @var int
     * @SerializedName('business_id')
     */
    public $businessId;
    /**
     * 支付方式
     * @var int
     * @SerializedName('pay_method')
     */
    public $payMethod;
    /**
     * @var ShoppingProduct[]
     * @SerializedName('shopping_product_list')
     */
    public $shoppingProductList;
}