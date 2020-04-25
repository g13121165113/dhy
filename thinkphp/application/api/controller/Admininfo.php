<?php
namespace app\api\controller;
use think\captcha\Captcha;
use app\api\model\Admin as adminmodel;
use \think\Db;
use think\Controller;
use think\Request;
class Admininfo extends Base
{
    /**
        获取核心代理商列表
     */
    public function admin()
    {
        $token = request()->param();
        $where = [];
        if (isset($token['name']) && !empty($token['name'])) {
            $where['name'] = ['like', '%' . $token['name'] . '%'];
        }
        if (isset($token['mobile']) and $token['mobile'] > 0) {
            $where['mobile'] = ['like', '%' . $token['mobile'] . '%'];
        }
        //获取该用户下面的核心代理商列表
        $index = new adminmodel();
        $list = $index->where($where)->where('status',1)->where('pid',$token['id'])->where('admin_cate_id',2)->select();
        if($list){
            return json(['status'=>1,'msg'=>'操作成功','data'=>$list]);
        }else{
            return json(['status'=>1,'msg'=>'操作成功','data'=>$list]);
        }
    }

    //获取编辑页面显示
    public function edit(){
        $id = request()->param('id');
        //通过id获取用户信息
        $index = new adminmodel();
        $list = $index->where('id',$id)->find();
        if($list){
            return json(['status'=>1,'msg'=>'操作成功','data'=>$list]);
        }else{
            return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
        }
    }

    //添加核心代理商
    public function addInfo(){
        $data = request()->param();
//        $id = $this->checkToken($data['token']);
        $data = array_splice($data,1);
        if(isset($data['id'])){
            //是编辑操作
            if(isset($data['password'])||isset($data['password1'])){
                if($data['password'] != $data['password1']){
                    return json(['status'=>2,'msg'=>'两次密码不一致','data'=>'']);
                }
                unset($data['password1']);
            }
            if(isset($data['mobile'])||empty($data['mobile'])){
                if(!preg_match("/^1[3456789]{1}\d{9}$/",$data['mobile'])){
                    return json(['status'=>2,'msg'=>'手机号格式不正确','data'=>'']);
                }
            }
            //更新数据
            $index = new adminmodel();
            $list = $index->where('id',$data['id'])->update($data);
            if(!empty($list) || $list == 0){
                return json(['status'=>1,'msg'=>'操作成功','data'=>$list]);
            }else{
                return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
            }
        }else{
            //是新增操作
            //验证数据
            if($data['password'] != $data['password1']){
                return json(['status'=>2,'msg'=>'两次密码不一致','data'=>'']);
            }
            unset($data['password1']);
            if(!preg_match("/^1[3456789]{1}\d{9}$/",$data['mobile'])){
                return json(['status'=>2,'msg'=>'手机号格式不正确','data'=>'']);
            }
            $data['add_time'] = time();
            $data['password'] = md5($data['password']);
            $data['pid'] = $data['url'];
            $data['admin_cate_id'] = 2;
            unset($data['url']);
            //保存到数据库
            $index = new adminmodel();
            $list = $index->insert($data);
            if($list){
                return json(['status'=>1,'msg'=>'操作成功','data'=>$list]);
            }else{
                return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
            }
        }
    }

    //删除用户
    public function del($id){
//        $data = request()->param();
//        $id = $this->checkToken($data['token']);
        $admin = new adminmodel();
        $data = $admin->where('id',$id)->update(['status'=>2]);
        if($data){
            return json(['status'=>1,'msg'=>'操作成功','data'=>'']);
        }else{
            return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
        }
    }


}
