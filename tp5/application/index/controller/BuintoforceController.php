<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Buintoforce;
use think\Controller;
use think\Request;
use think\Db;


class BuintoforceController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 100; // 每页显示100条数据
        $status = 1;
        // 实例化Teacher
        $Buintoforce = new Buintoforce;

        // 按条件查询数据并调用分页
        $buintoforces = $Buintoforce
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('status', 'like', '%' . $status . '%')
            ->order('score desc')
            ->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('buintoforces', $buintoforces);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
}