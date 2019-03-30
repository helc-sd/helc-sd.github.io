<?php
namespace app\index\controller;     // 该文件的位于application\index\controller文件夹

use think\Controller;   // 用于与V层进行数据传递

use app\common\model\Teacher;       // 教师模型

use think\Request;

/**
 * 教师管理，继承think\Controller后，就可以利用V层对数据进行打包了。
 */
class TeacherController extends IndexController{
    public function index(){
        // 获取查询信息
        $name = Request::instance()->get('name');

        $pageSize = 5; // 每页显示5条数据

        // 实例化Teacher
        $Teacher = new Teacher;

        // 按条件查询数据并调用分页
        $teachers = $Teacher->where('name', 'like', '%' . $name . '%')->paginate($pageSize, false, [
            'query'=>[
                'name' => $name,
            ],
        ]);

        // 向V层传数据
        $this->assign('teachers', $teachers);

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

            // 实例化Teacher空对象
            $Teacher = new Teacher();

            // 为对象赋值
            $Teacher->name = $postData['name'];
            $Teacher->username = $postData['username'];
            $Teacher->sex = $postData['sex'];
            $Teacher->email = $postData['email'];

            // 新增对象至数据表
            $result = $Teacher->save();

            // 反馈结果
            if (false === $result)
            {
                // 验证未通过，发生错误
                $message = '新增失败:' . $Teacher->getError();
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
        $Teacher = Teacher::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Teacher)) {
            // 删除对象
            if ($Teacher->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }
    public function edit(){
        $id = Request::instance()->param('id/d');
        //var_dump($id);
        // 获取传入ID
        // 在Teacher表模型中获取当前记录
        if (is_null($Teacher = Teacher::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Teacher', $Teacher);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }

    public function update(){
        // 接收数据
        $teacher = Request::instance()->post();

        // 将数据存入Teacher表
        $Teacher = new Teacher();
        $state = $Teacher->isUpdate(true)->save($teacher);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
}





























