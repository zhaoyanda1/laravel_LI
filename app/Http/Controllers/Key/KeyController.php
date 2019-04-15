<?php

/**
 * Created by PhpStorm.
 * User: 城府&
 * Date: 2019/04/04
 * Time: 18:08
 */
namespace App\Http\Controllers\Key;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class KeyController
{
   public function openssl(){
       $private_key = "/tmp/openssl/rsa_private.pem";
       $pblic_key = "/tmp/openssl/rsa_public.pem";

       $privatekey=file_get_contents($private_key);
       $publickey = file_get_contents($pblic_key);

       $data=[
           'private'=>$privatekey,
           'public'=>$publickey
       ];
       DB::table('key')->insert($data);
   }
    public function encode(Request $request){

        $key=DB::table('key')->first();
        $private_key=$key->private;
        $privatekey=openssl_pkey_get_private($private_key);
        $content=$request->input('name');
        $encryptData="";
        openssl_private_encrypt($content,$encryptData,$privatekey);
        $content = base64_encode($encryptData);
        echo $content;
        $this->decode($content);
    }
    public function decode($content){
        $key=DB::table('key')->first();
        $public_key=$key->public;
        $go="";
        $publickey=openssl_pkey_get_public($public_key);
        $content = base64_decode($content);
        openssl_public_encrypt($content,$go,$publickey);
        echo $go;
    }

}