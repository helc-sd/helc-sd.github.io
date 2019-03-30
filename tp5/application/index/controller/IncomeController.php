<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Income;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class IncomeController extends IndexController
{
    public function index(){

        // 获取查询信息
        $contract_id = Request::instance()->get('contract_id');
        $product_id = Request::instance()->get('product_id');
        $bu_name = Request::instance()->get('bu_name');
        $income_date_from = Request::instance()->get('income_date_from');
        $income_date_to = Request::instance()->get('income_date_to');
        Session::set('income_product_id',$product_id);
        Session::set('income_contract_id',$contract_id);
        Session::set('income_bu_name',$bu_name);
        Session::set('income_date_from',$income_date_from);
        Session::set('income_date_to',$income_date_to);
        $pageSize = 20; // 每页显示20条数据

        // 实例化Income
        $Income = new Income;

        // 按条件查询数据并调用分页
        $incomes = $Income
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->where('product_id', 'like', '%' . $product_id . '%')
            ->where('income_bu', 'like', '%' . $bu_name . '%')
            ->where('income_date', 'between time', [$income_date_from,$income_date_to])
            ->paginate($pageSize, false, ['query'=>request()->param()]);

        // 向V层传数据
        $this->assign('incomes', $incomes);

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
        $Income = new Income();

        // 为对象赋值
        $Income->product_id = $postData['product_id'];
        $Income->contract_id = $postData['contract_id'];
        $Income->income_type = $postData['income_type'];
        $Income->arrears_type = $postData['arrears_type'];
        $Income->company = $postData['company'];
        $Income->payee = $postData['payee'];
        $Income->receipt_id = $postData['receipt_id'];
        $Income->fund_name = $postData['fund_name'];
        $Income->classification = $postData['classification'];
        $Income->split_amount = $postData['split_amount'];
        $Income->income_way = $postData['income_way'];
        $Income->if_buyoff = $postData['if_buyoff'];
        $Income->buyer = $postData['buyer'];
        $Income->big_customer = $postData['big_customer'];
        $Income->big_project = $postData['big_project'];
        $Income->bu_name = $postData['bu_name'];
        $Income->income_date = $postData['income_date'];
        $Income->audit_status = $postData['audit_status'];
        $Income->bu_income = $postData['bu_income'];
        $Income->quarter_pay_add = $postData['quarter_pay_add'];
        $Income->quarter_cost_add = $postData['quarter_cost_add'];
        $Income->year_pay_add = $postData['year_pay_add'];
        $Income->year_cost_add = $postData['year_cost_add'];

        // 新增对象至数据表
        $result = $Income->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Income->getError();
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
        $Income = Income::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Income)) {
            // 删除对象
            if ($Income->delete()) {
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
        if (is_null($Income = Income::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Income', $Income);
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
        $income = Request::instance()->post();

        // 将数据存入Income表
        $Income = new Income();
        $state = $Income->isUpdate(true)->save($income);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    /*
     * 按区域汇总
     */
    public function coincome(){
        $result= Db::query("
SELECT IFNULL(SUBSTRING(company,1,2),'合计') as company,SUM(eq4) AS eq4,SUM(in4) AS in4,SUM(eq5) AS eq5,SUM(in5) AS in5,SUM(eq6) AS eq6,SUM(in6) AS in6,SUM(eq7) AS eq7,SUM(in7) AS in7,SUM(eq8) AS eq8,SUM(in8) AS in8,SUM(eq9) AS eq9,SUM(in9) AS in9,SUM(eq10) AS eq10,SUM(in10) AS in10,SUM(eq11) AS eq11,SUM(in11) AS in11,SUM(eq12) AS eq12,SUM(in12) AS in12,SUM(eq1) AS eq1,SUM(in1) AS in1,SUM(eq2) AS eq2,SUM(in2) AS in2,SUM(eq3) AS eq3,SUM(in3) AS in3,year
FROM helc_coincome
GROUP BY company WITH ROLLUP

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
        ini_set ('memory_limit', '1280M');
        $excel = new Office();
        $contract_id = Session::get('income_contract_id');
        $product_id = Session::get('income_product_id');
        $bu_name = Session::get('income_bu_name');
        $income_date_from = Session::get('income_date_from');
        $income_date_to = Session::get('income_date_to');
        $xlsName  = "入金明细表";
        $data  = Db::name('income')
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->where('product_id', 'like', '%' . $product_id . '%')
            ->where('income_bu', 'like', '%' . $bu_name . '%')
            ->where('income_date', 'between time', [$income_date_from,$income_date_to])
            ->select();
        //设置表头：
        $head = [ 'ID','生产工号', '合同号', '款项类型', '欠款类型', '入金分公司', '收款人', '收款编号', '收款款项名称', '分类', '收款拆分金额', '来款方式', '是否买断合同', '买方单位', '大客户', '大项目', '跨区域', '欠款-事业部', '入金-事业部', '事业部所在区域', '拆款日期', '审核状态', '事业部收入', '季度薪酬包增加', '季度费用包增加', '财年薪酬包增加', '财年费用包增加','条件'];
        //数据中对应的字段，用于读取相应数据：
        $keys = [ 'id','product_id', 'contract_id', 'income_type', 'arrears_type', 'company', 'payee', 'receipt_id', 'fund_name', 'classification', 'split_amount', 'income_way', 'if_buyoff', 'buyer', 'big_customer', 'big_project', 'cross_region', 'bu_name', 'income_bu', 'branch', 'income_date', 'audit_status', 'bu_income', 'quarter_pay_add', 'quarter_cost_add', 'year_pay_add', 'year_cost_add','condition'];

        $excel->outdata($xlsName, $head, $data, $keys);
    }

}