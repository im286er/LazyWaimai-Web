<?php

use common\helpers\Constants;

return [
    'adminEmail' => 'admin@example.com',

    /**
     * token的有效时间,单位:秒
     */
    Constants::TOKEN_VALID_SECOND => 30 * 24 * 60 * 60,

    /**
     * 注册用户的默认头像
     */
    Constants::USER_DEFAULT_AVATAR => 'http://palmorder-public.stor.sinaapp.com/images/ic_default_avatar.png',
];