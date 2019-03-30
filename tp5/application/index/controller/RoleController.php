<?php
namespace app\index\controller;
use app\common\model\Role;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;


class RoleController extends IndexController
{
    public function index(){
        // 获取查询信息
        $role_name = input('role_name');

        $pageSize = 10; // 每页显示10条数据

        // 实例化Role
        $Role = new Role;

        // 按条件查询数据并调用分页
        $roles = $Role->where('role_name', 'like', '%' . $role_name . '%')->paginate($pageSize, false, [
            'query'=>[
                'role_name' => $role_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('roles', $roles);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }


}