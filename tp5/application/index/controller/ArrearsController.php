<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Arrears;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class ArrearsController extends IndexController
{
    public function index(){

        // 获取查询信息
        $product_id = Request::instance()->get('product_id');
        $contract_id = Request::instance()->get('contract_id');
        $bu_name = Request::instance()->get('bu_name');
        $expire_date_from = Request::instance()->get('expire_date_from');
        $expire_date_to = Request::instance()->get('expire_date_to');
        Session::set('arrears_product_id',$product_id);
        Session::set('arrears_contract_id',$contract_id);
        Session::set('arrears_bu_name',$bu_name);
        Session::set('expire_date_from',$expire_date_from);
        Session::set('expire_date_to',$expire_date_to);
        $pageSize = 20; // 每页显示20条数据

        // 实例化Teacher
        $Arrears = new Arrears;
        // 按条件查询数据并调用分页
        $arrearss = $Arrears
            ->where('product_id', 'like', '%' . $product_id . '%')
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('expire_date', 'between time', [$expire_date_from,$expire_date_to])
            ->paginate($pageSize, false, ['query'=>request()->param()]);

        // 向V层传数据
        $this->assign('arrearss', $arrearss);

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
        $Arrears = new Arrears();

        // 为对象赋值
        $Arrears->product_id = $postData['product_id'];
        $Arrears->contract_id = $postData['contract_id'];
        $Arrears->buyer = $postData['buyer'];
        $Arrears->big_customer = $postData['big_customer'];
        $Arrears->big_project = $postData['big_project'];
        $Arrears->expire_date = $postData['expire_date'];
        $Arrears->arrears_amount = $postData['arrears_amount'];
        $Arrears->company = $postData['company'];
        $Arrears->arrears_staff = $postData['arrears_staff'];
        $Arrears->bu_name = $postData['bu_name'];
        $Arrears->arrears_type = $postData['arrears_type'];
        $Arrears->arrears_adjust = $postData['arrears_adjust'];
        // 新增对象至数据表
        $result = $Arrears->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Arrears->getError();
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
        $Arrears = Arrears::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Arrears)) {
            // 删除对象
            if ($Arrears->delete()) {
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
        if (is_null($Arrears = Arrears::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Arrears', $Arrears);
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
        $arrears = Request::instance()->post();

        // 将数据存入Arrears表
        $Arrears = new Arrears();
        $state = $Arrears->isUpdate(true)->save($arrears);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function bureport(){

        // 获取事业部名称
        $staff_bu = Session::get('staff_bu');
        // 获取分公司名称
        $company = Session::get('company');
        $pageSize = 35; // 每页显示5条数据

        // 实例化
        $Arrears = new Arrears;

        // 按条件查询数据并调用分页
        $arrearss = $Arrears
            ->where('bu_name', 'like', '%' . $staff_bu . '%')
            ->order('expire_date')
            ->paginate($pageSize, false, [
                'query'=>[
                    'bu_name' => $staff_bu,
                ],
            ]);
        /*        //事业部总体得分
                    $result1= Db::query("SELECT product_id,contract_id,buyer,expire_date,arrears_amount,arrears_staff,arrears_type,history_back,history_balance FROM `helc_arrears`
        WHERE bu_name='$staff_bu'
        ORDER BY expire_date;
        ");*/
        // 向V层传数据
        $this->assign('arrearss', $arrearss);
        $this->display();
        $htmls = $this->fetch();
        return $htmls;
    }
    //导出Excel
    function export(){
        ini_set ('memory_limit', '1280M');
        $product_id = Session::get('arrears_product_id');
        $contract_id = Session::get('arrears_contract_id');
        $bu_name = Session::get('arrears_bu_name');
        $expire_date_from = Session::get('expire_date_from');
        $expire_date_to = Session::get('expire_date_to');
        $excel = new Office();
        $xlsName  = "欠款明细表";
        $data = Db::name('arrears')
            ->where('product_id','like','%'.$product_id.'%')
            ->where('contract_id','like','%'.$contract_id.'%')
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('expire_date', 'between time', [$expire_date_from,$expire_date_to])
            ->select();

        //设置表头：
        $head = ['条件', '工号', '合同号', '买方单位', '大客户', '大项目', '到期应收日期', '欠款金额', '分公司', '欠款人', '事业部名称', '欠款类型', '历史欠款回收', '历史欠款结余'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['condition', 'product_id', 'contract_id', 'buyer', 'big_customer', 'big_project', 'expire_date', 'arrears_amount', 'company', 'arrears_staff', 'bu_name', 'arrears_type', 'history_back', 'history_balance'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }
    //事业部导出Excel
    function toexcel(){
        ini_set ('memory_limit', '1280M');
        $staff_bu = Session::get('staff_bu');
        $excel = new Office();
        $xlsName  = "事业部欠款明细表";
        $data = Db::name('arrears')
            ->where('bu_name','like','%'.$staff_bu.'%')
            ->order('expire_date')
            ->select();

        //设置表头：
        $head = ['条件', '工号', '合同号', '买方单位', '大客户', '大项目', '到期应收日期', '欠款金额', '分公司', '欠款人', '事业部名称', '欠款类型', '历史欠款回收', '历史欠款结余'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['condition', 'product_id', 'contract_id', 'buyer', 'big_customer', 'big_project', 'expire_date', 'arrears_amount', 'company', 'arrears_staff', 'bu_name', 'arrears_type', 'history_back', 'history_balance'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }
}