<?php

namespace restapi\settle;

use restapi\beans\SettleBody;
use restapi\beans\SettleResult;

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