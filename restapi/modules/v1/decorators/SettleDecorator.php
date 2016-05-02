<?php

namespace restapi\modules\v1\decorators;

use restapi\modules\v1\beans\SettleBody;
use restapi\modules\v1\beans\SettleResult;

abstract class SettleDecorator {

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public abstract function settleBefore($settleBody, $settleResult);

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public abstract function settleAfter($settleBody, $settleResult);
}