<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Sdquarterindex;
use think\Controller;
use think\Request;
use think\Db;
class SdquarterindexController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('id');

        $pageSize = 35; // 每页显示5条数据

        // 实例化Teacher
        $Sdquarterindex = new Sdquarterindex;

        // 按条件查询数据并调用分页
        $sdquarterindexs = $Sdquarterindex->where('year', 'like', '%' . 2018 . '%')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('sdquarterindexs', $sdquarterindexs);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
}