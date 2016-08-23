<?php

namespace App;

class Encrypt
{
    static $method = 'AES-128-CBC';
    static $password = '@Complex!password1';
    static $iv = 'a16bytelongiv000';

    static function encrypt($data){
        return base64_encode(openssl_encrypt($data,Encrypt::$method,Encrypt::$password,false,Encrypt::$iv));
    }

    static function decrypt($data){
        return openssl_decrypt(base64_decode($data),Encrypt::$method,Encrypt::$password,false,Encrypt::$iv);
    }
}
