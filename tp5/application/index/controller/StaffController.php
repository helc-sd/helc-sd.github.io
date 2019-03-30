<?php
namespace app\index\controller;
use app\common\model\Staff;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
//use PHPExcel_IOFactory;
//use PHPExcel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StaffController extends IndexController{
    public function index(){
        // 获取查询信息
        $staff_name = input('staff_name');
        Session::set('staff_staff_name',$staff_name);
        $pageSize = 15; // 每页显示10条数据

        // 实例化Staff
        $Staff = new Staff;

        // 按条件查询数据并调用分页
        $staffs = $Staff->where('staff_name', 'like', '%' . $staff_name . '%')
            ->paginate($pageSize, false, [
            'query'=>[
                'staff_name' => $staff_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('staffs', $staffs);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function add()
    {
        try {
            $htmls = $this->fetch();
            return $htmls;
        } catch (\Exception $e) {
            return '系统错误' . $e->getMessage();
        }
    }
    //插入数据
    public function insert(){
        // 接收传入数据
        $postData = Request::instance()->post();

        // 实例化Staff空对象
        $Staff = new Staff();

        // 为对象赋值
        $Staff->staff_id = $postData['staff_id'];
        $Staff->staff_name = $postData['staff_name'];
        $Staff->sex = $postData['sex'];
        $Staff->password = $postData['password'];
        $Staff->role = $postData['role'];
        $Staff->company = $postData['company'];
        // 新增对象至数据表
        $result = $Staff->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Staff->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
    }
    //编辑
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Staff表模型中获取当前记录
        if (is_null($Staff = Staff::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Staff', $Staff);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $staff = Request::instance()->post();

        // 将数据存入Bustaff表
        $Staff = new Staff();
        $state = $Staff->isUpdate(true)->save($staff);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function changepw()
    {
        // 修改密码
        $staff_id = session('staff_id');
        // 向V层传数据
        $this->assign('staff_id', $staff_id);
        return $this->fetch();
    }
    public function pwupdate()
    {
        // 接收数据
        $a = Request::instance()->post();
        $b=md5($a['password']);
        $c = Session::get('staff_id');
        $sql="UPDATE helc_staff SET password = '$b' WHERE id = '$c'";
        //执行插入操作
        $affected = Db::execute($sql);
        //判断是否执行成功
        if ($affected){
            $this->success('更新成功!',url('Login/logout'),'',3);
        }else{
            $this->error('更新失败');
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
        $Staff = Staff::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Staff)) {
            // 删除对象
            if ($Staff->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }
    //导出Excel
    function export(){
        //ini_set ('memory_limit', '2048M');
        $excel = new Office();
        $staff_name = Session::get('staff_staff_name');
        $xlsName  = "用户信息表";
        $data = Db::name('staff')
            ->where('staff_name','like','%'.$staff_name.'%')
            ->select();

        //设置表头：
        $head = ['ID', '员工编号', '员工姓名', '性别', '密码', '角色', '分公司', '创建时间', '更新时间'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'staff_id', 'staff_name', 'sex', 'password', 'role', 'company', 'create_time', 'update_time'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }

}