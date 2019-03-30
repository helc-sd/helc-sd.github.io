<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Bustaff;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class BustaffController extends IndexController
{
    public function index(){
        // 获取查询信息
        $staff_name = input('staff_name');
        $staff_bu = input('staff_bu');
        Session::set('bustaff_bustaff_name',$staff_name);
        Session::set('bustaff_staff_bu',$staff_bu);

        $pageSize = 15; // 每页显示15条数据

        // 实例化Teacher
        $Bustaff = new Bustaff;

        // 按条件查询数据并调用分页
        $bustaffs = $Bustaff
            ->where('staff_name', 'like', '%' . $staff_name . '%')
            ->where('staff_bu', 'like', '%' . $staff_bu . '%')
            ->paginate($pageSize, false, ['query'=>request()->param()]);

        // 向V层传数据
        $this->assign('bustaffs', $bustaffs);

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
        $Bustaff->if_quit = $postData['if_quit'];

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
        ini_set ('memory_limit', '1280M');
        $staff_name = Session::get('bustaff_bustaff_name');
        $staff_bu = Session::get('bustaff_staff_bu');
        $excel = new Office();
        $xlsName  = "事业部成员明细";
        $data = Db::name('bustaff')
            ->where('staff_name','like','%'.$staff_name.'%')
            ->where('staff_bu', 'like', '%' . $staff_bu . '%')
            ->select();

        //设置表头：
        $head = ['ID', '员工编号', '姓名', '岗位', '所属事业部', '分公司', '是否CEO', '是否离职', '创建时间', '更新时间'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'staff_id', 'staff_name', 'staff_post', 'staff_bu', 'company', 'if_ceo', 'if_quit', 'create_time', 'update_time'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }

}