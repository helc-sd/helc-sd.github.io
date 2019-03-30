<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Profit;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;

class ProfitController extends IndexController
{
    public function index(){
        // 获取查询信息
        $bu_name = input('bu_name');

        $pageSize = 10; // 每页显示10条数据

        // 实例化Profit
        $Profit = new Profit;

        // 按条件查询数据并调用分页
        $profits = $Profit->where('bu_name', 'like', '%' . $bu_name . '%')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('profits', $profits);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function report(){
        // 获取查询信息
        $staff_bu = Session::get('staff_bu');

        $pageSize = 100; // 每页显示100条数据

        // 实例化Profit
        $Profit = new Profit;

        // 按条件查询数据并调用分页
        $profits = $Profit
                    ->where('bu_name', 'like', '%' . $staff_bu . '%')
                    ->order('profit_bonus desc')
                    ->paginate($pageSize, false, ['query'=>request()->param()]);

        // 向V层传数据
        $this->assign('profits', $profits);

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
        $Bustaff = new Bustaff();

        // 为对象赋值
        $Bustaff->staff_id = $postData['staff_id'];
        $Bustaff->staff_name = $postData['staff_name'];
        $Bustaff->staff_post = $postData['staff_post'];
        $Bustaff->staff_bu = $postData['staff_bu'];
        $Bustaff->company = $postData['company'];
        $Bustaff->if_ceo = $postData['if_ceo'];

        // 新增对象至数据表
        $result = $Bustaff->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Bustaff->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
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
    public function delete()
    {
        // 获取get数据
        // 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”
        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }
        $Bustaff = Bustaff::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Bustaff)) {
            // 删除对象
            if ($Bustaff->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Bustaff = Bustaff::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Bustaff', $Bustaff);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $bustaff = Request::instance()->post();

        // 将数据存入Bustaff表
        $Bustaff = new Bustaff();
        $state = $Bustaff->isUpdate(true)->save($bustaff);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    //导出Excel
    function export(){
        $staff_name = input('staff_name');
        $xlsName  = "export";//设置导出文件名称
        //表头
        $xlsCell  = array(
            array('id','ID'),
            array('staff_id','员工编号'),
            array('staff_name','姓名'),
            array('staff_post','岗位'),
            array('staff_bu','所属事业部'),
            array('company','分公司'),
            array('if_ceo','是否CEO'),
        );
        $xlsData  = Db::name('bustaff')->select();
        var_dump($xlsData);
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }
}