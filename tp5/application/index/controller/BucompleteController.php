<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Bucomplete;
use think\Controller;
use think\Request;
use think\Db;


class BucompleteController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 100; // 每页显示5条数据
        $status = 1;

        // 实例化Teacher
        $Bucomplete = new Bucomplete;

        // 按条件查询数据并调用分页
        $bucompletes = $Bucomplete
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('status', 'like', '%' . $status . '%')
            ->order('score desc')
            ->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('bucompletes', $bucompletes);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
}