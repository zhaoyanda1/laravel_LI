<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ApiController extends Controller
{
    public function reg(Request $request){
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');
        echo json_encode($user_name);die;
//        return json_encode(
//            [
//                'status'=>1,
//                'msg'=>'该用户已被注册，请换个重试！'
//            ]
//        );
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

    public function api_login(Request $request){
        $user_name = $request->input('user_name');
        $user_pwd = $request->input('user_pwd');
        $data = [
            'user_name'=>$user_name,
            'user_pwd'=>$user_pwd
        ];
        $url = 'http://fcz.96myshop.cn/login';
        //初始化
        $curl = curl_init();
//设置抓取的url
        curl_setopt($curl, CURLOPT_URL,$url);
//设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, false);
//设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//执行命令
        $encode = curl_exec($curl);
//关闭URL请求
        curl_close($curl);
//显示获得的数据

        return $encode;

    }
}