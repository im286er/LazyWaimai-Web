<?php

namespace restapi\modules\v1\context;

use yii;
use yii\web\BadRequestHttpException;
use restapi\modules\v1\decorators\SettleDecorator;
use restapi\modules\v1\beans\SettleBody;
use restapi\modules\v1\beans\SettleResult;

class CartSettleHandler {

    /**
     * @var SettleBody
     */
    private $settleBody;

    /**
     * @var SettleResult
     */
    private $settleResult;

    /**
     * @var SettleDecorator[]
     */
    private $decorators = [];

    /**
     * SettleHandler constructor.
     * @param $settleBody
     */
    public function __construct($settleBody) {
        $this->settleBody = $settleBody;

        $this->settleResult = new SettleResult();
    }

    /**
     * 添加结算项目的装配器
     * @param SettleDecorator $decorator
     */
    public function addDecorator(SettleDecorator $decorator) {
        $this->decorators[] = $decorator;
    }

    /**
     * 结算之前
     */
    private function settleBefore() {
        foreach ($this->decorators as $decorator) {
            /** @var $decorator SettleDecorator */
            $decorator->settleBefore($this->settleBody, $this->settleResult);
        }
    }

    /**
     * 结算之后调用
     */
    private function settleAfter() {
        foreach ($this->decorators as $decorator) {
            /** @var $decorator SettleDecorator */
            $decorator->settleAfter($this->settleBody, $this->settleResult);
        }
    }

    /**
     * 处理购物车结算
     * @return SettleResult
     * @throws BadRequestHttpException
     */
    public function handleCartSettle() {
        $this->settleBefore();

        // nothing to do!

        $this->settleAfter();

        return $this->settleResult;
    }
}