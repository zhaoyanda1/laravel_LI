<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function login(Request $request){
        //  echo 111;
        //    exit;
        $name = $request->input('u_name');
        $password=$request->input('u_pwd');
        $data = [
            'u_name'    =>  $name,
            'u_pwd'     =>  $password
        ];
        //$url = 'http://passport.lara.com/api/login';
        $url = 'http://pass.hz4155.cn/api/login';
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response,true);


        return $response;



    }
    //前台登陆接口
    public function loginll(Request $request){
        $data=$request->input();
        $user_tel=$data['user_tel'];
        $user_pwd=$data['user_pwd'];
        $arr=[
            'user_tel'=>$user_tel,
            'user_pwd'=>md5($user_pwd),
        ];
        $arrUser=UserModel::where($arr)->first();
        if($arrUser){
            $user_id=$arrUser->user_id;
            $user_tel=$arrUser->user_tel;
            session(['user_id'=>$user_id,'user_tel'=>$user_tel]);
            return json_encode([
                'code'=>1,
                'msg'=>'登陆成功',
                'user_id'=>$user_id
            ]);
        }else{
            return json_encode([
                'code'=>0,
                'msg'=>'登陆失败'
            ]);
        }
    }

}