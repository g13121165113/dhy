<?php
namespace app\api\model;

use think\Model;

class Admin extends Model
{
    //验证用户登录
    public function index(){
        $data = request()->param();
        $list = Admin::where('name',$data['name'])->where('del',1)->where('password',md5($data['password']))->find();
        return $list;
    }
    //
    public function info(){
        $list = Admin::where('del',1)->select();
        return $list;
    }
}