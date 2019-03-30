<?php
namespace app\index\controller;
use app\common\model\Bycontract;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class BycontractController extends IndexController
{
    public function index(){
        // 获取查询信息
        $contract_id = input('bycontract_contract_id');
        Session::set('bycontract_contract_id',$contract_id);

        $pageSize = 10; // 每页显示10条数据

        // 实例化Bycontract
        $Bycontract = new Bycontract;

        // 按条件查询数据并调用分页
        $bycontracts = $Bycontract
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->paginate($pageSize, false, [
            'query'=>[
                'contract_id' => $contract_id,
            ],
        ]);

        // 向V层传数据
        $this->assign('bycontracts', $bycontracts);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function audit(){
        // 获取查询信息
        $contract_id = input('bycontract_contract_id');
        Session::set('bycontract_contract_id',$contract_id);
        $party_a = input('bycontract_party_a');
        Session::set('bycontract_party_a',$party_a);
        $pageSize = 10; // 每页显示10条数据

        // 实例化Bycontract
        $Bycontract = new Bycontract;

        // 按条件查询数据并调用分页
        $bycontracts = $Bycontract
            ->where('contract_id', 'like', '%' . $contract_id . '%')
            ->where('party_a', 'like', '%' . $party_a . '%')
            ->paginate($pageSize, false, ['query'=>request()->param()]);

        // 向V层传数据
        $this->assign('bycontracts', $bycontracts);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    //新增按钮
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
     * 往数据库插入数据
     */
    public function insert(){
        // 接收传入数据
        $postData = Request::instance()->post();

        // 实例化Bustaff空对象
        $Bycontract = new Bycontract();

        // 为对象赋值
        $Bycontract->contract_id = $postData['contract_id'];
        $Bycontract->company = $postData['company'];
        $Bycontract->business_manager = $postData['business_manager'];
        $Bycontract->party_a = $postData['party_a'];
        $Bycontract->party_b = $postData['party_b'];
        $Bycontract->contract_type = $postData['contract_type'];
        $Bycontract->project_name = $postData['project_name'];
        $Bycontract->contract_amount = $postData['contract_amount'];
        $Bycontract->submission_date = $postData['submission_date'];
        // 新增对象至数据表
        $result = $Bycontract->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Bycontract->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
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
        $Bycontract = Bycontract::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Bycontract)) {
            // 删除对象
            if ($Bycontract->delete()) {
                return $this->success('删除成功', url('audit'));
            }
        }

        return '删除失败';

    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Bycontract = Bycontract::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Bycontract', $Bycontract);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function auditedit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Bycontract = Bycontract::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Bycontract', $Bycontract);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $bycontract = Request::instance()->post();

        // 将数据存入Bustaff表
        $Bycontract = new Bycontract();
        $state = $Bycontract->isUpdate(true)->save($bycontract);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function auditupdate(){
        // 接收数据
        $bycontract = Request::instance()->post();

        // 将数据存入Bustaff表
        $Bycontract = new Bycontract();
        $state = $Bycontract->isUpdate(true)->save($bycontract);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('audit'));
        } else {
            return '更新失败';
        }
    }
    //导出Excel
    function export(){
        ini_set ('memory_limit', '1280M');
        $contract_id = Session::get('bycontract_contract_id');
        $excel = new Office();
        $xlsName  = "保养合同审核明细表";
        $data = Db::name('bycontract')
            ->where('contract_id','like','%'.$contract_id.'%')
            ->select();

        //设置表头：
        $head = ['ID', '合同号', '分公司', '业务经理', '甲方', '乙方', '合同类型', '项目名称', '合同金额', '售后服务部提交时间', '合同部接收日期', '盖章日期', '审核人'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'contract_id', 'company', 'business_manager', 'party_a', 'party_b', 'contract_type', 'project_name', 'contract_amount', 'submission_date', 'receiving_date', 'stamp_date', 'auditor'];
        $excel->outdata($xlsName, $head, $data, $keys);
    }
}