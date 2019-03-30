<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Bufdetail;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class BufdetailController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 35; // 每页显示5条数据

        // 实例化Teacher
        $Bufdetail = new Bufdetail;

        // 按条件查询数据并调用分页
        $bufdetails = $Bufdetail
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->order('id')
            ->paginate($pageSize, false, [
            'query'=>[
            'bu_name' => $bu_name,
            ],
        ]);
        // 向V层传数据
        $this->assign('bufdetails', $bufdetails);
        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function report(){
        // 获取事业部名称
        $staff_bu = Session::get('staff_bu');
        $pageSize = 100; // 每页显示100条数据
        // 实例化
        $Bufdetail = new Bufdetail;
        // 按条件查询数据并调用分页
        $bufdetails = $Bufdetail
            ->where('bu_name', 'like', '%' . $staff_bu . '%')
            ->order('create_time desc')
            ->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $staff_bu,
            ],
        ]);
        // 向V层传数据
        $this->assign('bufdetails', $bufdetails);
        // 取回打包后的数据
        $htmls = $this->fetch();
        // 将数据返回给用户
        return $htmls;
    }
    public function year(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 35; // 每页显示5条数据

        // 实例化
        $Bufdetail = new Bufdetail;

        // 按条件查询数据并调用分页
        $bufdetails = $Bufdetail->where('bu_name', 'like', '%' . $bu_name . '%')->order('quarter_pay_balance desc')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);
        // 向V层传数据
        $this->assign('bufdetails', $bufdetails);
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
        $Bufdetail = new Bufdetail();

        // 为对象赋值
        $Bufdetail->bu_name = $postData['bu_name'];
        $Bufdetail->company = $postData['company'];
        $Bufdetail->quarter_pay = $postData['quarter_pay'];
        $Bufdetail->quarter_cost = $postData['quarter_cost'];
        $Bufdetail->year_pay = $postData['year_pay'];
        $Bufdetail->year_cost = $postData['year_cost'];
        $Bufdetail->month = $postData['month'];
        $Bufdetail->year = $postData['year'];
        $Bufdetail->remarks = $postData['remarks'];

        // 新增对象至数据表
        $result = $Bufdetail->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Bufdetail->getError();
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
        $Bufdetail = Bufdetail::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Bufdetail)) {
            // 删除对象
            if ($Bufdetail->delete()) {
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
        if (is_null($Bufdetail = Bufdetail::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Bufdetail', $Bufdetail);
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
        $bufdetail = Request::instance()->post();
        //var_dump($bufdetail);
        // 将数据存入Bufdetail表
        $Bufdetail = new Bufdetail();
        $state = $Bufdetail->isUpdate(true)->save($bufdetail);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    //事业部生效明细
    public function buintoforce()
    {
        $staff_bu = Session::get('staff_bu');

        $result= Db::query("
SELECT year,po,co,br,helc_bustaff.staff_bu 
FROM
(SELECT helc_contract.project_name AS po,count(product_id) AS co,sales_person as br,date_format(into_force_date,'%y-%m') AS year,belong_to
FROM helc_contract,helc_product
WHERE helc_contract.contract_id = helc_product.contract_id AND status='正常' AND if_into_force = '是'  AND into_force_date BETWEEN '2018-04-01' AND '2019-03-31' 
GROUP BY po,br,belong_to)AS A,helc_bustaff
WHERE helc_bustaff.staff_name=A.br AND staff_bu = '$staff_bu'
ORDER BY year
");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    //事业部完工明细
    public function bucomplete()
    {
        $staff_bu = Session::get('staff_bu');

        $result= Db::query("
SELECT year,supervisor,project_name,sum,install_company,helc_bustaff.staff_bu
FROM helc_bustaff,
(SELECT date_format(complete_date,'%y-%m') AS year,supervisor,helc_contract.project_name,COUNT(helc_product.product_id) AS sum,install_company 
FROM helc_product,helc_contract
WHERE helc_product.contract_id = helc_contract.contract_id AND complete_date BETWEEN '2018-04-01' AND '2019-03-31'
GROUP BY project_name,supervisor
ORDER BY year,sum) AS A
WHERE helc_bustaff.staff_name = A.supervisor AND staff_bu = '$staff_bu'
ORDER BY year,sum
");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    //事业部收款明细
    public function buincome()
    {
        $staff_bu = Session::get('staff_bu');

        $result= Db::query("
SELECT date_format(income_date,'%y-%m') AS year,contract_id,buyer,payee,SUM(split_amount) AS sum,income_way,bu_name
FROM helc_income
WHERE bu_name='$staff_bu'
GROUP BY contract_id,year,payee,income_way
");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    //导出Excel
    function export(){
        $bu_name = input('bu_name');
        $xlsName  = "export";//设置导出文件名称
        //表头
        $xlsCell  = array(
            array('id','ID'),
            array('bu_name','事业部名称'),
            array('company','分公司'),
            array('quarter_pay','季度薪酬池'),
            array('quarter_cost','季度费用池'),
            array('year_pay','财年薪酬池'),
            array('year_cost','财年费用池'),
            array('month','月份'),
            array('year','财年'),
            array('remarks','备注'),
            array('create_time','创建时间'),
            array('update_time','更新时间'),
        );
        $xlsData  = Db::name('bufdetail')->select();
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }
}