<?php
namespace app\api\model;

use think\Model;

class Menu extends Model
{
    public function index(){
        $data = request()->param();
        $list = Cate::where('name',$data['name'])->where('password',md5($data['password']))->find();
        return $list;
    }
    public function info(){
        $list = Admin::where('del',1)->select();
        return $list;
    }


}