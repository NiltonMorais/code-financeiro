<?php

namespace CodeFin\Jwt;

use \Tymon\JWTAuth\Manager as JwtManager;
use Tymon\JWTAuth\Token;

class Manager extends JwtManager{

    public function refresh(Token $token, $forceForever = false, $resetClaims = false)
    {
        $this->setRefreshFlow();
        return parent::refresh($token, $forceForever, $resetClaims);
    }
}