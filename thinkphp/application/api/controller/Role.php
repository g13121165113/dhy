<?php
namespace app\api\controller;
use app\api\model\Admin as adminmodel;
use app\api\model\Cate as catemodel;
use app\api\model\Menu as menumodel;
use \think\Db;
use think\Controller;
use think\Request;
/**
 * 角色管理
 *
 */
class Role extends Base
{
    /**
     * 初始化方法
     */
    public function __construct(Request $request) {
        parent::__construct($request); //在子类，实现父类的构造函数
    }
    //获取当前登录用户的菜单信息
    public function index(){
        $token = request()->param();
//        $id = $this->checkToken($token['token']);
        $admin = new adminmodel();
        $cateid = $admin ->where('id',$token['id'])->value('admin_cate_id');
        //通过权限id获取该用户所有的权限
        $cate = new catemodel();
        $role = $cate->where('id',$cateid)->value('permissions');
        //把权限变成数组
        $pieces = explode(",", $role);
        $men = new menumodel();
        //获取该用户下所有的权限
        //获取所有的一级目录结构
        $menu = Db('menu')->where('id','in',$pieces)->where('pid',0)->select();
        //查询一级下面的二级分类
        foreach($menu as $k=>$v){
            $menu[$k]['list'] = Db('menu')->where('pid',$v['id'])->where('id','in',$pieces)->select();
            foreach($menu[$k]['list'] as $kay=>$val){
                $menu[$k]['list'][$kay]['url'] = $val['url'].'?'.$token['id'];
            }
        }
        if($menu){
            return json(['status'=>1,'msg'=>'操作成功','data'=>$menu]);
        }else{
            return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
        }
    }


    //获取所有角色信息
    public function role(){
        $cate = new catemodel();
        $name = $cate->index();
        if($name){
            return json(['status'=>1,'msg'=>'操作成功','data'=>$name]);
        }else{
            return json(['status'=>2,'msg'=>'操作失败','data'=>'']);
        }
    }

}
