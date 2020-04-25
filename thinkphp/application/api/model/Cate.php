<?php
namespace app\api\model;

use think\Model;

class Cate extends Model
{
    public function index(){
        $list = Cate::select();
        return $list;
    }
    public function info(){
        $list = Admin::where('del',1)->select();
        return $list;
    }
}