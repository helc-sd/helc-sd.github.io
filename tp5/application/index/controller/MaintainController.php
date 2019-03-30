<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/7/16
 * Time: 9:40
 */

namespace app\index\controller;
use app\common\model\Maintain;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;

class MaintainController extends IndexController
{
    public function index(){
        // 获取查询信息
        $company = input('company');

        $pageSize = 20; // 每页显示20条数据

        // 实例化Maintain
        $Maintain = new Maintain;

        // 按条件查询数据并调用分页
        $maintains = $Maintain->where('company', 'like', '%' . $company . '%')->paginate($pageSize, false, [
            'query'=>[
                'company' => $company,
            ],
        ]);

        // 向V层传数据
        $this->assign('maintains',$maintains);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Maintain = Maintain::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Maintain', $Maintain);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $maintain = Request::instance()->post();

        // 将数据存入Maintain表
        $Maintain = new Maintain();
        $state = $Maintain->isUpdate(true)->save($maintain);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function maintain()
    {
        // 获取查询信息
        $company = input('company');

        $pageSize = 20; // 每页显示20条数据

        // 实例化Maintain
        $Maintain = new Maintain;

        // 按条件查询数据并调用分页
        $maintains = $Maintain->where('company', 'like', '%' . $company . '%')->paginate($pageSize, false, [
            'query' => [
                'company' => $company,
            ],
        ]);

        // 向V层传数据
        $this->assign('maintains', $maintains);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function maintainedit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Maintain = Maintain::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Maintain', $Maintain);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function maintainupdate(){
        // 接收数据
        $maintain = Request::instance()->post();

        // 将数据存入Maintain表
        $Maintain = new Maintain();
        $state = $Maintain->isUpdate(true)->save($maintain);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('maintain'));
        } else {
            return '更新失败';
        }
    }
    public function repair()
    {
        // 获取查询信息
        $company = input('company');

        $pageSize = 20; // 每页显示20条数据

        // 实例化Maintain
        $Maintain = new Maintain;

        // 按条件查询数据并调用分页
        $maintains = $Maintain->where('company', 'like', '%' . $company . '%')->paginate($pageSize, false, [
            'query' => [
                'company' => $company,
            ],
        ]);

        // 向V层传数据
        $this->assign('maintains', $maintains);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function repairedit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Maintain = Maintain::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Maintain', $Maintain);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function repairupdate(){
        // 接收数据
        $maintain = Request::instance()->post();

        // 将数据存入Maintain表
        $Maintain = new Maintain();
        $state = $Maintain->isUpdate(true)->save($maintain);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('repair'));
        } else {
            return '更新失败';
        }
    }
    public function profit()
    {
        // 获取查询信息
        $company = input('company');

        $pageSize = 20; // 每页显示20条数据

        // 实例化Maintain
        $Maintain = new Maintain;

        // 按条件查询数据并调用分页
        $maintains = $Maintain->where('company', 'like', '%' . $company . '%')->paginate($pageSize, false, [
            'query' => [
                'company' => $company,
            ],
        ]);

        // 向V层传数据
        $this->assign('maintains', $maintains);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function profitedit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Maintain = Maintain::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Maintain', $Maintain);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function profitupdate(){
        // 接收数据
        $maintain = Request::instance()->post();

        // 将数据存入Maintain表
        $Maintain = new Maintain();
        $state = $Maintain->isUpdate(true)->save($maintain);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('profit'));
        } else {
            return '更新失败';
        }
    }
}