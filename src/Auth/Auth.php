<?php

namespace App\Auth;
use \Firebase\JWT\JWT;

class Auth {
    private static $secret_key = '1';
    private static $encrypt = 'HS256';
    private static $aud = null;

    public static function SignIn($data) {
        $time = time();
        $token = array(
            "iss" => "http://localhost",
            "iat" =>  $time,
            "exp" => $time+43200,
            'aud' => self::Aud(),
            'data' => [
                "user_id" => $data["user_id"],
                "scope" => $data['scope']
            ]
        );

        return JWT::encode($token, self::$secret_key, self::$encrypt);

    }

    public static function Check($token)
    {
        if(empty($token))
        {
            throw new Exception("Invalid token supplied.");
        }

        $decode = JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );

        if($decode->aud !== self::Aud())
        {
            throw new Exception("Invalid user logged in.");
        }
    }

    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }

}