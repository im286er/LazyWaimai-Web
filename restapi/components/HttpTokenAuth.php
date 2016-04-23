<?php

namespace restapi\components;

use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use restapi\models\User;
use restapi\models\Token;


class HttpTokenAuth extends AuthMethod {

    public $tokenParam = 'Http-Access-Token';
    public $deviceIdParam = 'Http-Device-Id';

    public function authenticate($user, $request, $response) {
        $token = $request->headers->get($this->tokenParam);
        $deviceId = $request->headers->get($this->deviceIdParam);

        if ($token !== null && $deviceId !== null) {
            $tokenModel = Token::validateIdentity($token, $deviceId);
            /** @var $identity IdentityInterface */
            $identity = User::findOne($tokenModel['user_id']);

            if ($identity !== null) {
                $user->switchIdentity($identity);
            } else {
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }
}