<?php

/**
 * Created by PhpStorm.
 * User: 城府&
 * Date: 2019/04/04
 * Time: 18:08
 */
namespace App\Http\Controllers\Key;
use App\Http\Controllers\Controller;
class KeyController
{
    public function key(){
        $private_key = "/tmp/openssl/rsa_private.pem";
        $pblic_key = "/tmp/openssl/rsa_public.pem";

        $privatekey=openssl_pkey_get_private(file_get_contents($private_key));

        $publickey = openssl_pkey_get_public(file_get_contents($pblic_key));

        $content = "这是原始文件";
        $encryptData="";
        $go="";
        openssl_private_encrypt($content,$encryptData,$privatekey);

        $content = base64_encode($encryptData);




        $content = base64_decode($content);
        openssl_public_decrypt($content,$go,$publickey);

        echo $go;
    }
}