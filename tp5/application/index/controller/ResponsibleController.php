<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/7/23
 * Time: 14:02
 */

namespace app\index\controller;
use app\common\model\Responsible;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class ResponsibleController extends IndexController{

    public function index(){
        // 获取查询信息
        $name = input('name');

        $pageSize = 20; // 每页显示20条数据

        // 实例化Responsible
        $Responsible = new Responsible;

        // 按条件查询数据并调用分页
        $responsibles = $Responsible->where('name', 'like', '%' . $name . '%')->paginate($pageSize, false, [
            'query'=>[
                'name' => $name,
            ],
        ]);

        // 向V层传数据
        $this->assign('responsibles', $responsibles);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    /*
         * 往数据库插入数据
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
    public function insert(){
        // 接收传入数据
        $postData = Request::instance()->post();

        // 实例化Responsible空对象
        $Responsible = new Responsible();

        // 为对象赋值
        $Responsible->emid = $postData['emid'];
        $Responsible->name = $postData['name'];
        $Responsible->company = $postData['company'];
        $Responsible->position = $postData['position'];
        $Responsible->status = $postData['status'];
        // 新增对象至数据表
        $result = $Responsible->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Responsible->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
    }
    /*删除数据*/
    public function delete()
    {
        // 获取get数据
        // 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”
        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }
        $Responsible = Responsible::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Responsible)) {
            // 删除对象
            if ($Responsible->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Responsible表模型中获取当前记录
        if (is_null($Responsible =Responsible::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Responsible', $Responsible);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $responsible = Request::instance()->post();

        // 将数据存入Responsible表
        $Responsible = new Responsible();
        $state = $Responsible->isUpdate(true)->save($responsible);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    //导出Excel
    function export(){
        ini_set ('memory_limit', '1280M');
        $excel = new Office();
        $xlsName  = "营业/监理/收款专员";
        $data = Db::name('responsible')
            ->select();

        //设置表头：
        $head = ['ID', '工号', '姓名', '分公司', '职位', '状态', '创建时间', '更新时间'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'emid', 'name', 'company', 'position', 'status', 'create_time', 'update_time'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }
}