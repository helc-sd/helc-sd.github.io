<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:24
 */

namespace app\index\controller;
use app\common\model\Sdcompanyindex;
use think\Controller;
use think\Request;
use think\Db;
use think\Session;
class SdcompanyindexController extends IndexController
{
    public function index(){

        // 获取查询信息
        $bu_name = Request::instance()->get('id');

        $pageSize = 35; // 每页显示5条数据

        // 实例化Teacher
        $Sdcompanyindex = new Sdcompanyindex;

        // 按条件查询数据并调用分页
        $sdcompanyindexs = $Sdcompanyindex->where('year', 'like', '%' . 2018 . '%')->order('sign_complete')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('sdcompanyindexs', $sdcompanyindexs);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function install(){

        // 获取查询信息
        $bu_name = Request::instance()->get('id');

        $pageSize = 35; // 每页显示5条数据

        // 实例化Teacher
        $Sdcompanyindex = new Sdcompanyindex;

        // 按条件查询数据并调用分页
        $sdcompanyindexs = $Sdcompanyindex->where('year', 'like', '%' . 2018 . '%')->order('install_complete')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('sdcompanyindexs', $sdcompanyindexs);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function arrears(){

        // 获取查询信息
        $bu_name = Request::instance()->get('id');

        $pageSize = 35; // 每页显示5条数据

        // 实例化Teacher
        $Sdcompanyindex = new Sdcompanyindex;

        // 按条件查询数据并调用分页
        $sdcompanyindexs = $Sdcompanyindex->where('year', 'like', '%' . 2018 . '%')->order('recovery')->paginate($pageSize, false, [
            'query'=>[
                'bu_name' => $bu_name,
            ],
        ]);

        // 向V层传数据
        $this->assign('sdcompanyindexs', $sdcompanyindexs);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    public function companycomplete()
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
SELECT date_format(complete_date,'%y-%m') AS year,supervisor,helc_contract.project_name,COUNT(helc_product.product_id) AS sum,install_company 
FROM helc_product,helc_contract
WHERE helc_product.contract_id = helc_contract.contract_id AND install_company = '$company'AND complete_date BETWEEN '2018-04-01' AND '2019-03-31'
GROUP BY project_name,supervisor
ORDER BY year,sum

");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
    /*分公司重点跟进项目明细*/
    public function coimportant()
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
SELECT sales_person,project_name,quote_num 
FROM helc_quote
WHERE branch_office = '$company' AND win_biding = '0'AND sign_contract = '0' AND if_not_winning <> '是' 
ORDER BY sales_person,quote_num ASC
");
        // 向V层传数据
        $this->assign('result', $result);
        // 取回打包后的数据
        $htmls = $this->fetch();
        // 将数据返回给用户
        return $htmls;
    }
    public function companyarrears()
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
SELECT date_format(complete_date,'%y-%m') AS year,supervisor,helc_contract.project_name,COUNT(helc_product.product_id) AS sum,install_company 
FROM helc_product,helc_contract
WHERE helc_product.contract_id = helc_contract.contract_id AND install_company = '$company'AND complete_date BETWEEN '2018-04-01' AND '2019-03-31'
GROUP BY supervisor
ORDER BY year,sum

");

        // 向V层传数据
        $this->assign('result', $result);

        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
    }
}