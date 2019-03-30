<?php
namespace app\index\controller;
use think\Controller;   // 用于与V层进行数据传递
use think\Request;
use app\common\model\Staff;   // 员工模型
class LoginController extends Controller
{
    // 用户登录表单
    public function index()
    {
        // 显示登录表单
        return $this->fetch();
    }
    public function welcome()
    {
        // 显示首页
        return $this->fetch();
    }
    public function changepw()
    {
        // 显示首页
        return $this->fetch();
    }

    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $postData = Request::instance()->post();

        // 直接调用M层方法，进行登录。
        if (Staff::login($postData['staff_id'], $postData['password'])) {
            return $this->success('登陆成功', url('Index/welcome'),'','1');
        } else {
            return $this->error('用户名或密码不正确', url('index'));
        }
    }
    // 注销
    public function logOut()
    {
        if (Staff::logOut()) {
            return $this->success('注销成功', url('index'));
            session('name',null);
            session('staff_id',null);
            session('[destroy]');
        } else {
            return $this->error('注销错误', url('index'));
        }
    }
}