<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/7/23
 * Time: 14:02
 */

namespace app\index\controller;
use app\common\model\Reason;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;
class ReasonController extends IndexController{

    public function index(){
    // 获取查询信息
    $company = input('company');

    $pageSize = 20; // 每页显示20条数据

    // 实例化Reason
    $Reason = new Reason;

    // 按条件查询数据并调用分页
    $reasons = $Reason->where('company', 'like', '%' . $company . '%')->paginate($pageSize, false, [
        'query'=>[
            'company' => $company,
        ],
    ]);

    // 向V层传数据
    $this->assign('reasons', $reasons);

    // 取回打包后的数据
    $htmls = $this->fetch();

    // 将数据返回给用户
    return $htmls;
    }
    /*
         * 往数据库插入数据
         */
    public function insert(){
        // 接收传入数据
        $postData = Request::instance()->post();

        // 实例化Reason空对象
        $Reason = new Reason();

        // 为对象赋值
        $Reason->company = $postData['company'];
        $Reason->notcollect = $postData['notcollect'];
        $Reason->pending = $postData['pending'];
        $Reason->sublawsuit = $postData['sublawsuit'];
        $Reason->notexpired = $postData['notexpired'];
        $Reason->inprocess = $postData['inprocess'];
        // 新增对象至数据表
        $result = $Reason->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Reason->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Reason表模型中获取当前记录
        if (is_null($Reason =Reason::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Reason', $Reason);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $reason = Request::instance()->post();

        // 将数据存入Reason表
        $Reason = new Reason();
        $state = $Reason->isUpdate(true)->save($reason);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
}