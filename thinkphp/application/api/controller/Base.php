<?php
namespace app\api\controller;
use think\captcha\Captcha;
use app\api\model\Admin as adminmodel;
use \think\Db;
use think\Controller;
use think\Request;
class Base extends Controller
{
    /**
     * 初始化方法
     */
    public function __construct(Request $request) {
        parent::__construct($request); //在子类，实现父类的构造函数
//        if(session('id') == null){
//            echo json_encode(['status'=>3,'msg'=>'暂未登录','data'=>'']);die;   //没有登录
//        }
    }




    /*
        验证token
    */
    public function checkToken(){
        $token = request()->param();
        if(empty($token)){
            echo json_encode(['status'=>2,'msg'=>'token错误','data'=>'']);die;
        }
//        $index = new adminmodel();
        //查询token
        $user_info = Db('admin')->where(['token'=>$token['token']])->find();
        if(!empty($user_info)){
            if($user_info['status'] == 0){
                echo json_encode(['status'=>2,'msg'=>'token错误','data'=>'']);die;
            }else{
                //根据token获取用户id
                return $user_info['id'];
            }
        }else{
            echo json_encode(['status'=>2,'msg'=>'token错误','data'=>'']);die;
        }
    }



}
