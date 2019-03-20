<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ApiController extends Controller
{
    public function reg(Request $request){
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');

        $user = DB::table('api_user')->where(['user_name'=>$user_name])->first();
        if($user){
            return json_encode(
                [
                    'status'=>1,
                    'msg'=>'该用户已被注册，请换个重试！'
                ]
            );
        }

        $res = DB::table('api_user')->insert(['user_name'=>$user_name,'user_pwd'=>$user_pwd]);
        if($res){
            return json_encode(
                [
                    'status'=>1000,
                    'msg'=>'注册成功'
                ]
            );
        }else{
            return json_encode(
                [
                    'status'=>1,
                    'msg'=>'注册失败'
                ]
            );
        }



    }

    public function login(Request $request){
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');

        $res = DB::table('api_user')->where(['user_name'=>$user_name,'user_pwd'=>$user_pwd])->first();
        if($res){
            return json_encode(
                [
                    'status'=>1000,
                    'msg'=>'登录成功'
                ]
            );
        }else{
            return json_encode(
                [
                    'status'=>1,
                    'msg'=>'账号或密码错误'
                ]
            );
        }



    }

}