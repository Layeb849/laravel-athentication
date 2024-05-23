<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTtoken
{
    public static function createToken($userEmail, $userId)
    {

        $key = 'example_key';
        $payload = [
            'iss' => 'login cokis',
            'iat' => time(),
            'exp' => time() + 20,
            'userEmail' => $userEmail,
            'userId' => $userId
        ];
        return JWT::encode($payload, $key, 'HS256');
    }
    public static function verifyToken($token)
    {
        try {
            if ($token === null) {
                return 'unauthorize';
            } else {
                $key = 'example_key';
                return JWT::decode($token, new Key($key, 'HS256'));
            }
        } catch (Exception $a) {
            return  $a->getMessage();
        }
    }
}
