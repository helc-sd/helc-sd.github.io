<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Budrawing;
use think\Controller;
use think\Request;
use think\Db;

class BudrawingController extends IndexController
{
    public function index(){

        // 获取查询信息
        $staff_name = Request::instance()->get('staff_name');

        $pageSize = 20; // 每页显示5条数据

        // 实例化Teacher
        $Budrawing = new Budrawing;

        // 按条件查询数据并调用分页
        $budrawings = $Budrawing->where('staff_name', 'like', '%' . $staff_name . '%')->paginate($pageSize, false, [
            'query'=>[
                'staff_name' => $staff_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('budrawings', $budrawings);

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

        // 实例化Bustaff空对象
        $Budrawing = new Budrawing();

        // 为对象赋值
        $Budrawing->staff_id = $postData['staff_id'];
        $Budrawing->staff_name = $postData['staff_name'];
        $Budrawing->staff_bu = $postData['staff_bu'];
        $Budrawing->drawing_amount = $postData['drawing_amount'];
        $Budrawing->drawing_date = $postData['drawing_date'];

        // 新增对象至数据表
        $result = $Budrawing->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Budrawing->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
    }
    /*
     * 删除数据
     */
    public function delete()
    {
        // 获取get数据
        // 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”
        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }
        $Budrawing = Budrawing::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Budrawing)) {
            // 删除对象
            if ($Budrawing->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }

    /*
     * 提交表单
     */
    public function add()
    {
        try {
            $htmls = $this->fetch();
            return $htmls;
        } catch (\Exception $e) {
            return '系统错误' . $e->getMessage();
        }
    }
    /*
     * 获取要修改的数据
     */
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Budrawing = Budrawing::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Budrawing', $Budrawing);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    /*
     * 更新数据
     */
    public function update(){
        // 接收数据
        $budrawing = Request::instance()->post();
        //var_dump($budrawing);
        // 将数据存入Budrawing表
        $Budrawing = new Budrawing();
        $state = $Budrawing->isUpdate(true)->save($budrawing);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
}