<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Buthisyear;
use think\Controller;
use think\Request;
use think\Db;
class ButhisyearController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 100; // 每页显示5条数据
        $status =  1;

        // 实例化Teacher
        $Buthisyear = new Buthisyear;

        // 按条件查询数据并调用分页
        $buthisyears = $Buthisyear
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('status', 'like', '%' . $status . '%')
            ->order('score desc')
            ->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('buthisyears', $buthisyears);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
}