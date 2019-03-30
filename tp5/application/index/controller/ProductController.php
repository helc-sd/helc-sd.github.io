<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Product;
use think\Controller;
use think\Request;
use think\Db;
use PHPExcel_IOFactory;
use PHPExcel;
use think\Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends IndexController
{
    public function index(){

        // 获取查询信息
        $product_id = Request::instance()->get('product_id');

        $pageSize = 5; // 每页显示5条数据

        // 实例化Teacher
        $Product = new Product;

        // 按条件查询数据并调用分页
        $products = $Product->where('product_id', 'like', '%' . $product_id . '%')->paginate($pageSize, false, [
            'query'=>[
                'product_id' => $product_id,
            ],
        ]);

        // 向V层传数据
        $this->assign('products', $products);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    //区域生效明细
    public function companyintoforce()
    {
        $company_name = Session::get('company');
        // 获取查询信息
        $companys = Request::instance()->get('company');

        if (empty($companys))
        {
            $company=$company_name;
        } else {
            $company=$companys;
        }
        $result= Db::query("SELECT helc_contract.project_name as po,count(product_id) AS co,sales_person as br,date_format(into_force_date,'%y-%m') AS year,belong_to FROM helc_contract,helc_product WHERE helc_contract.contract_id = helc_product.contract_id AND status='正常' AND if_into_force = '是' AND belong_to = '$company' AND into_force_date between '2018-04-01' AND '2019-03-31' group by po,br,belong_to order by year,br,co asc");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function preintoforce()
    {
        $company_name = Session::get('company');
        // 获取查询信息
        $companys = Request::instance()->get('company');

        if (empty($companys))
        {
            $company=$company_name;
        } else {
            $company=$companys;
        }
        $result= Db::query("
SELECT project_name AS po,count(product_id) AS co,sales_clerk AS br,datediff(now(),both_seal_date) AS ds 
FROM helc_contract,helc_product 
WHERE  helc_contract.contract_id = helc_product.contract_id AND sd_status='正常' AND belong_to = '$company' AND helc_product.if_into_force = '否'  
GROUP BY po ORDER BY br,co,ds ASC
");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function presign()
    {
        $company_name = Session::get('company');
        // 获取查询信息
        $companys = Request::instance()->get('company');

        if (empty($companys))
        {
            $company=$company_name;
        } else {
            $company=$companys;
        }
        $result= Db::query("
SELECT project_name,SUM(bid_num) AS total,sales_person 
FROM(
SELECT branch_office, sales_person,quote_num,helc_quote.project_name,project_type AS '项目类型',customer_attributes AS '客户分类',elevator_model AS '电梯型号',bid_num,win_bidding_date AS '中标日期' 
FROM `helc_quote` 
WHERE win_biding = '1'AND sign_contract = '0' AND if_not_winning <> '是' 
UNION 
SELECT branch_office, sales_person AS '营业员',quote_num,helc_quote.project_name,customer_attributes AS '客户分类',bidding_type AS '招标类型',elevator_model AS '电梯型号',bid_num,win_bidding_date AS '中标日期' 
FROM `helc_quote`,`helc_contract` 
WHERE sign_contract = '1' AND if_not_winning <> '是' AND helc_quote.contract_id = helc_contract.contract_id AND helc_contract.courier_date='0000-00-00') AS A 
WHERE branch_office ='$company'  
GROUP BY project_name 
ORDER BY sales_person,total ASC
");

        // 向V层传数据
        $this->assign('result', $result);

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
        $Product = new Product();

        // 为对象赋值
        $Product->product_id = $postData['product_id'];
        $Product->contract_id = $postData['contract_id'];
        $Product->buyer = $postData['buyer'];
        $Product->big_customer = $postData['big_customer'];
        $Product->big_project = $postData['big_project'];
        $Product->expire_date = $postData['expire_date'];
        $Product->Product_amount = $postData['Product_amount'];
        $Product->company = $postData['company'];
        $Product->Product_staff = $postData['Product_staff'];
        $Product->bu_name = $postData['bu_name'];
        $Product->Product_type = $postData['Product_type'];
        $Product->Product_adjust = $postData['Product_adjust'];
        // 新增对象至数据表
        $result = $Product->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Product->getError();
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
        $Product = Product::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Product)) {
            // 删除对象
            if ($Product->delete()) {
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
        if (is_null($Product = Product::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Product', $Product);
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
        $product = Request::instance()->post();

        // 将数据存入Product表
        $Product = new Product();
        $state = $Product->isUpdate(true)->save($product);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function complete(){
        // 获取查询信息
        $contract_id = Request::instance()->get('contract_id');
        $supervisor = Request::instance()->get('supervisor');
        $complete_date_from = Request::instance()->get('complete_date_from');
        $complete_date_to = Request::instance()->get('complete_date_to');
        Session::set('contract_id',$contract_id);
        Session::set('supervisor',$supervisor);
        Session::set('complete_date_from',$complete_date_from);
        Session::set('complete_date_to',$complete_date_to);
        $pageSize = 10; // 每页显示10条数据
        // 实例化Product
        $Product = new Product;

        // 按条件查询数据并调用分页
        $products = $Product
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->where('supervisor', 'like', '%' . $supervisor . '%')
            ->where('complete_date', 'between time', [$complete_date_from,$complete_date_to])
            ->order('product_id')
            ->paginate($pageSize, false, ['query'=>request()->param()]);
        // 向V层传数据
        $this->assign('products', $products);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function completeEdit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Product表模型中获取当前记录
        if (is_null($Product = Product::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Product', $Product);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function batchcomplete(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Product表模型中获取当前记录
        if (is_null($Product = Product::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Product', $Product);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function completeUpdate(){
        // 接收数据
        $product = Request::instance()->post();
        //var_dump($product);
        // 将数据存入Product表
        $Product = new Product();
        $state = $Product->isUpdate(true)->save($product);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('complete'));
        } else {
            return '更新失败';
        }
    }
    public function close(){
        // 获取查询信息
        $contract_id = Request::instance()->get('contract_id');

        $pageSize = 10; // 每页显示5条数据

        // 实例化Product
        $Product = new Product;

        // 按条件查询数据并调用分页
        $products = $Product->where('contract_id', 'like', '%' . $contract_id . '%')->paginate($pageSize, false, [
            'query'=>[
                'contract_id' => $contract_id,
            ],
        ]);

        // 向V层传数据
        $this->assign('products', $products);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function closeEdit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Product表模型中获取当前记录
        if (is_null($Product = Product::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 将数据传给V层
        $this->assign('Product', $Product);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function closeUpdate(){
        // 接收数据
        $product = Request::instance()->post();
        //var_dump($product);
        // 将数据存入Product表
        $Product = new Product();
        $state = $Product->isUpdate(true)->save($product);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('关闭成功', url('close'));
        } else {
            return '关闭失败';
        }
    }
    public function shut(){
        // 获取传入ID
        $id = Request::instance()->param('product_id/d');
        // 在Product表模型中获取当前记录
        if (is_null($Product = Product::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }
        // 接收数据
        $product = Request::instance()->post();

        // 将数据存入Product表
        $Product = new Product();
        $state = $Product->isUpdate(true)->save($product);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    //导出Excel
    function exportClose(){
        ini_set ('memory_limit', '1280M');
        $contract_id = Session::get('contract_id');
        $xlsName  = "export";
        //表头
        $xlsCell  = array(
            array('id','ID'),
            array('product_id','生产工号'),
            array('contract_id','合同号'),
            array('sales_person','营业员'),
            array('belong_to','绩效归属'),
            array('complete_date','完工日期'),
            array('close_date','关闭日期'),
        );
        $xlsData  = Db::name('product')->where('contract_id','like','%'.$contract_id.'%')->select();
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
    }
    function exportComplete(){
        ini_set ('memory_limit', '1280M');
        $excel = new Office();
        $contract_id = Session::get('contract_id');
        $supervisor = Session::get('supervisor');
        $complete_date_from = Session::get('complete_date_from');
        $complete_date_to = Session::get('complete_date_to');
        $data  = Db::name('product')
            ->where('contract_id','like','%'.$contract_id.'%')
            ->where('supervisor', 'like', '%' . $supervisor . '%')
            ->where('complete_date', 'between time', [$complete_date_from,$complete_date_to])
            ->select();
        //设置表头：
        $head = ['ID', '生产工号', '合同号', '项目经理', '发货日期', '进场日期', '完工日期', 'PDA录入是否及时', '实际安装支出', '关闭日期'];
        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'product_id', 'contract_id', 'supervisor', 'delivery_date', 'entry_date', 'complete_date', 'pda_intime', 'installation_expenditure', 'close_date'];

        $excel->outdata('完工信息表', $head, $data, $keys);
    }
}