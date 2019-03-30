<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use think\Request;
use app\common\model\Staff;   // 员工模型
use think\Db;
use think\Session;
class LayoutController extends IndexController
{
    // 用户登录表单
    public function header()
    {
        //获取session
        $id = session('staff_id');
        var_dump($id);
        $result= Db::name('staff')->where('id',$id)->select();
        $role=$result[0]['role'];
        Session::set('role',$role);
        $auth=Db::name('role')->where('role_name',$role)->select();
        $bureport = $auth[0]['report'];
        Session::set('report',$bureport);

    }
}