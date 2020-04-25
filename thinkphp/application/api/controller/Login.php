<?php
namespace app\api\controller;
use think\captcha\Captcha;
use app\api\model\Admin as adminmodel;
use \think\Db;
use think\Controller;
use think\Request;

    class Login extends Base
{
    /*
        生成token
    */
    public function setToken(){
        $string = 'duoshanghu'.uniqid(mt_rand().time(),true);
        return $string;
    }
    /**
        用户登录
     */
    public function login(){
        //获取用户输入的信息
        $data = request()->param();
        if(isset($data['id'])){
//            $id = $this->checkToken($data['token']);
            //登录该账户
            $index = new adminmodel();
            $list = $index->where('id',$data['id'])->find();
//            if(empty($list['token'])){
                $list['token'] = $this->setToken();
//            }
            Db('admin')->where('id',$list['id'])->update(['token'=>$list['token']]);
            if($list){
                return json(['status'=>1,'msg'=>'操作成功','data'=>['token'=>$list['token'],'id'=>$list['id']]]);
            }else{
                return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
            }
        }else{
            //实例化验证
            $index = new adminmodel();
            $list = $index->index($data);
            //获取
            if($list){
                $token = $this->setToken();
                    //保存到数据库
                Db('admin')->where('id',$list['id'])->update(['token'=>$token]);
                //获取当前登录用户的左侧菜单
                return json(['status'=>1,'msg'=>'操作成功','data'=>['token'=>$token,'id'=>$list['id']]]);
            }else{
                return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
            }
        }
    }

    public function aaa($id){
        $data = Db('admin')->where('id',$id)->find();
        if($data){
            $token = $this->setToken();
            //保存到数据库
            Db('admin')->where('id',$data['id'])->update(['token'=>$token]);
            //获取当前登录用户的左侧菜单
            return json(['status'=>1,'msg'=>'操作成功','data'=>['token'=>$token,'id'=>$data['id']]]);
        }else{
            return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
        }
    }

}
