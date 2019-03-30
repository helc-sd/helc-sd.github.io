<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Buscore;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class BuscoreController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('bu_name');

        $pageSize = 100; // 每页显示5条数据
        $status =1;

        // 实例化Teacher
        $Buscore = new Buscore;

        // 按条件查询数据并调用分页
        $buscores = $Buscore
            ->where('bu_name', 'like', '%' . $bu_name . '%')
            ->where('status', 'like', '%' . $status . '%')
            ->order('score desc')
            ->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('buscores', $buscores);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function report(){

        // 获取事业部名称
        $staff_bu = Session::get('staff_bu');
        // 获取分公司名称
        $company = Session::get('company');
        //事业部总体得分
        if ($company=='山东分公司') {
            $result1= Db::query('SELECT rank,bu_sname,FORMAT(intoforce,2) AS intoforce,FORMAT(complete,2) AS complete,FORMAT(thisyear,2) AS thisyear,convert(history, decimal(12,2)) AS history,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buscore WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result1= Db::query("SELECT rank,bu_sname,intoforce,complete,thisyear,history,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buscore WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部生效得分
        if ($company=='山东分公司') {
            $result2= Db::query('SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buintoforce WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result2= Db::query("SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buintoforce WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部完工得分
        if ($company=='山东分公司') {
            $result3= Db::query('SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_bucomplete WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result3= Db::query("SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_bucomplete WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部当年欠款得分
        if ($company=='山东分公司') {
            $result4= Db::query('SELECT rank,bu_sname,convert(contract_amount, decimal(12,2)) AS contract_amount,convert(this_arrears, decimal(12,2)) AS this_arrears,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buthisyear WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result4= Db::query("SELECT rank,bu_sname,convert(contract_amount, decimal(12,2)) AS contract_amount,convert(this_arrears, decimal(12,2)) AS this_arrears,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buthisyear WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部历史欠款得分
        if ($company=='山东分公司') {
            $result5= Db::query('SELECT rank,bu_sname,convert(arrears, decimal(12,2)) AS arrears,convert(recovery, decimal(12,2)) AS recovery,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buarrears WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result5= Db::query("SELECT rank,bu_sname,convert(arrears, decimal(12,2)) AS arrears,convert(recovery, decimal(12,2)) AS recovery,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buarrears WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }

        // 向V层传数据
        $this->assign('result1', $result1);
        $this->assign('result2', $result2);
        $this->assign('result3', $result3);
        $this->assign('result4', $result4);
        $this->assign('result5', $result5);
        $this->display();
        $htmls = $this->fetch();
        return $htmls;
    }
}