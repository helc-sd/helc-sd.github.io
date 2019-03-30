<?php
namespace app\index\controller;
use app\common\model\Salesperson;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class SalespersonController extends IndexController{

    public function index(){
        // 获取查询信息
        $emid = input('id');
        // 实例化Salesperson
        $Salesperson = new Salesperson;
        // 按条件查询数据并调用分页
        $salesperson = Db::name('salesperson')
            ->where('emid','like','%'.$emid.'%')
            ->select();
        //SESSION传参
        $name=$salesperson[0]['name'];
        Session::set('salesperson_name',$name);
        $company=$salesperson[0]['company'];
        Session::set('salesperson_company',$company);
        $bu_name=$salesperson[0]['bu_name'];
        Session::set('salesperson_bu_name',$bu_name);
        $this->assign('salesperson', $salesperson);
        $this->display();
        $htmls = $this->fetch();
        return $htmls;
    }

}