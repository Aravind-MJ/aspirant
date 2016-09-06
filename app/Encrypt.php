<?php

namespace App;

class Encrypt
{
    static $method = 'AES-128-CBC';
    static $password = '';
    static $iv = 'a16bytelongiv000';

    static function encrypt($data){
        Encrypt::$password = date('d/m/y');
        return base64_encode(openssl_encrypt($data,Encrypt::$method,Encrypt::$password,false,Encrypt::$iv));
    }

    static function decrypt($data){
        Encrypt::$password = date('d/m/y');
        return openssl_decrypt(base64_decode($data),Encrypt::$method,Encrypt::$password,false,Encrypt::$iv);
    }
}
