<?php
namespace app\index\controller;
use app\common\model\Litigation;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
use PHPExcel_IOFactory;
use PHPExcel;


class LitigationController extends IndexController
{
    public function index(){
        // 获取查询信息
        $contract_id = input('contract_id');
        Session::set('contract_id',$contract_id);

        $pageSize = 10; // 每页显示10条数据

        // 实例化Litigation
        $Litigation = new Litigation;

        // 按条件查询数据并调用分页
        $litigations = $Litigation->where('contract_id', 'like', '%' . $contract_id . '%')->paginate($pageSize, false, [
            'query'=>[
                'contract_id' => $contract_id,
            ],
        ]);

        // 向V层传数据
        $this->assign('litigations', $litigations);

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
        $Litigation = new Litigation();

        // 为对象赋值
        $Litigation->contract_id = $postData['contract_id'];
        $Litigation->company = $postData['company'];
        $Litigation->buyer = $postData['buyer'];
        $Litigation->letter_date = $postData['letter_date'];
        $Litigation->eq_litigation = $postData['eq_litigation'];
        $Litigation->in_litigation = $postData['in_litigation'];
        $Litigation->ma_litigation = $postData['ma_litigation'];
        $Litigation->bid_bond = $postData['bid_bond'];
        $Litigation->type = $postData['type'];
        $Litigation->if_close = $postData['if_close'];
        $Litigation->progress = $postData['progress'];
        // 新增对象至数据表
        $result = $Litigation->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Litigation->getError();
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
        $Litigation = Litigation::get($id);// 获取要删除的对象
        // 要删除的对象存在
        if (!is_null($Litigation)) {
            // 删除对象
            if ($Litigation->delete()) {
                return $this->success('删除成功', url('index'));
            }
        }

        return '删除失败';

    }
    public function edit(){
        // 获取传入ID
        $id = Request::instance()->param('id/d');
        // 在Teacher表模型中获取当前记录
        if (is_null($Litigation = Litigation::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        }

        // 将数据传给V层
        $this->assign('Litigation', $Litigation);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function update(){
        // 接收数据
        $litigation = Request::instance()->post();

        // 将数据存入Bustaff表
        $Litigation = new Litigation();
        $state = $Litigation->isUpdate(true)->save($litigation);

        //var_dump($state);
        // 依据状态定制提示信息
        if ($state) {
            return $this->success('更新成功', url('index'));
        } else {
            return '更新失败';
        }
    }
    public function report(){
        //未结诉讼
        $result3= Db::query('SELECT contract_id,SUBSTRING(company,1,2) AS company,buyer,letter_date,IFNULL(eq_litigation,0)+IFNULL(in_litigation,0)+IFNULL(ma_litigation,0)+IFNULL(bid_bond,0) AS amount,progress
FROM helc_litigation
WHERE type = \'诉讼\' AND if_close = \'否\'
');
        //未结律师函
        $result4= Db::query('SELECT contract_id,SUBSTRING(company,1,2) AS company,buyer,letter_date,IFNULL(eq_litigation,0)+IFNULL(in_litigation,0)+IFNULL(ma_litigation,0)+IFNULL(bid_bond,0) AS amount,progress
FROM helc_litigation
WHERE type = \'律师函\' 
');
        //诉讼已申请
        $result5= Db::query('SELECT contract_id,SUBSTRING(company,1,2) AS company,buyer,letter_date,IFNULL(eq_litigation,0)+IFNULL(in_litigation,0)+IFNULL(ma_litigation,0)+IFNULL(bid_bond,0) AS amount,progress
FROM helc_litigation
WHERE type = \'诉讼\' AND if_close = \'是\'
');
        $this->assign('result3', $result3);
        $this->assign('result4', $result4);
        $this->assign('result5', $result5);
        $this->display();
        $htmls = $this->fetch();
        return $htmls;
    }
    //导出Excel
    function export(){
        ini_set ('memory_limit', '1280M');
        $contract_id = Session::get('contract_id');
        $excel = new Office();
        $xlsName  = "诉讼律师函明细表";
        $data = Db::name('litigation')
            ->where('contract_id','like','%'.$contract_id.'%')
            ->select();

        //设置表头：
        $head = ['ID', '合同号', '分公司', '买方单位', '发函日期', '买卖合同起诉金额', '安装合同起诉金额', '维保合同起诉金额', '投标保证金', '类型', '是否结案', '进展情况'];

        //数据中对应的字段，用于读取相应数据：
        $keys = ['id', 'contract_id', 'company', 'buyer', 'letter_date', 'eq_litigation', 'in_litigation', 'ma_litigation', 'bid_bond', 'type', 'if_close', 'progress'];
        $excel->outdata($xlsName, $head, $data, $keys);
    }

}