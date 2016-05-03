<?php

namespace common\helpers;

class Constants {

    /**
     * token的有效时间,单位:秒
     * @var string
     */
    const TOKEN_VALID_SECOND = 'Token-Valid-Second';

    /**
     * 用户的默认头像
     */
    const USER_DEFAULT_AVATAR = 'User-Default-avatar';

    /**
     * header里的身份标识
     */
    const HTTP_ACCESS_TOKEN = 'Http-Access-Token';

    /**
     * header里的设备ID
     */
    const HTTP_DEVICE_ID = 'Http-Device-Id';

    /**
     * header里的设备类型
     */
    const HTTP_DEVICE_TYPE = 'Http-Device-Type';

    /**
     * header里的APP版本
     */
    const HTTP_APP_VERSION = 'Http-App-Version';

    /**
     * header里的时间戳
     */
    const HTTP_TIMESTAMP = 'Http-Timestamp';

}