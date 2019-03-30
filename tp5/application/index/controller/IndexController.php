<?php
namespace app\index\controller;     //命名空间，也说明了文件所在的文件夹
use think\Db;
use think\Controller;
use app\common\model\Staff;      // 引入员工
use think\Session;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 * IndexController既是类名，也是文件名，说明这个文件的名字为Index.php。
 * 由于其子类需要使用think\Controller中的函数，所以在此必须进行继承，并在构造函数中，进行父类构造函数的初始化
 */
class IndexController extends Controller
{
    //定义控制器初始化方法_initialize，在该控制器的方法调用之前首先执行。
    public function _initialize()
    {
        if(!session('staff_id')){
            return $this->error('请先登录系统',url('Login/index'));
        }
        //获取session
        $id = session('staff_id');
        //$result= Db::name('staff')->where('id',$id)->select();
        $result= Db::query("SELECT * FROM helc_staff WHERE id = '$id'");
        $role=$result[0]['role'];
        Session::set('role',$role);
        $staff_ids=$result[0]['staff_id'];
        Session::set('staff_ids',$staff_ids);
        $staff_name=$result[0]['staff_name'];
        Session::set('staff_name',$staff_name);
        $company=$result[0]['company'];
        Session::set('company',$company);
        //
        $auth=Db::name('role')->where('role_name',$role)->select();
        $sdreport = $auth[0]['report'];
        Session::set('sdreport',$sdreport);
        $coreport = $auth[0]['coreport'];
        Session::set('coreport',$coreport);
        $bureport = $auth[0]['bureport'];
        Session::set('bureport',$bureport);
        $yyglb = $auth[0]['yyglb'];
        Session::set('yyglb',$yyglb);
        $cwglb = $auth[0]['cwglb'];
        Session::set('cwglb',$cwglb);
        $htglb = $auth[0]['htglb'];
        Session::set('htglb',$htglb);
        $azglb = $auth[0]['azglb'];
        Session::set('azglb',$azglb);
        $rlzyb = $auth[0]['rlzyb'];
        Session::set('rlzyb',$rlzyb);
        $shfwb = $auth[0]['shfwb'];
        Session::set('shfwb',$shfwb);
        $admin = $auth[0]['admin'];
        Session::set('admin',$admin);
        $main = $auth[0]['main'];
        Session::set('main',$main);
        $sale = $auth[0]['sale'];
        Session::set('sale',$sale);
        $install = $auth[0]['install'];
        Session::set('install',$install);
        $maintain = $auth[0]['maintain'];
        Session::set('maintain',$maintain);
        $arrears = $auth[0]['arrears'];
        Session::set('arrears',$arrears);
        $litigation = $auth[0]['litigation'];
        Session::set('litigation',$litigation);
        $rivals = $auth[0]['rivals'];
        Session::set('rivals',$rivals);
        //获取事业部名称
        $bustaff= Db::query("SELECT * FROM helc_bustaff WHERE staff_id = '$staff_ids'");
        if (empty($bustaff)) {

        }else{
            // 是否为空
            $staff_bus = $bustaff[0]['staff_bu'];
            Session::set('staff_bu',$staff_bus);
        }


        $newdate=Db::query('SELECT into_force_date FROM `helc_product` ORDER BY into_force_date DESC LIMIT 0,1');
        $intoforce = $newdate[0]['into_force_date'];
        Session::set('intoforce_date',$intoforce);
        $installdate=Db::query('SELECT complete_date FROM `helc_product` ORDER BY complete_date DESC LIMIT 0,1');
        $complete = $installdate[0]['complete_date'];
        Session::set('complete_date',$complete);
        //财年使用进度
        $yearday=Db::query('SELECT pass,today,week FROM `helc_day`');
        $yearpass = $yearday[0]['pass'];
        Session::set('yearpass',$yearpass);
        $today_date = $yearday[0]['today'];
        Session::set('today_date',$today_date);
        $today_week = $yearday[0]['week'];
        Session::set('today_week',$today_week);
        //生效完工进度
        $progress=Db::query('SELECT sign_rate,install_rate,arrears_rate,convert(this_year_rate, decimal(12,2)) AS this_year_rate FROM `helc_sdcompanyindex` WHERE company = \'合计\' AND `year` = 2018');
        $sign_rate = $progress[0]['sign_rate'];
        Session::set('sign_rate',$sign_rate);
        $install_rate = $progress[0]['install_rate'];
        Session::set('install_rate',$install_rate);
        $arrears_rate = $progress[0]['arrears_rate'];
        Session::set('arrears_rate',$arrears_rate);
        $this_year_rate = $progress[0]['this_year_rate'];
        Session::set('this_year_rate',$this_year_rate);

    }

    public function report()
     {
         $result= Db::query('select * from helc_quarter_sdindex where year = "2018"');
         // 向V层传数据
         $this->assign('result', $result);

         // 取回打包后的数据
         $htmls = $this->fetch();

         // 将数据返回给用户
         return $htmls;
     }
    public function welcome()
    {
        //提交登陆信息
        $staff_ids = Session::get('staff_ids');
        $staff_name = Session::get('staff_name');
        $create_time = date("Y-m-d H:i:s");
        $company = Session::get('company');
        if ($staff_ids=='11824') {
            $Model = Db::execute("INSERT INTO helc_log SET staff_id = '$staff_ids',staff_name = '$staff_name',create_time = '$create_time'");

        }else {
            $Model = Db::execute("INSERT INTO helc_log SET staff_id = '$staff_ids',staff_name = '$staff_name',create_time = '$create_time'");
            /*file_get_contents('https://sc.ftqq.com/SCU35806Td8fe2e1a86260c043e9865c41cf3a9d05becb947a9cad.send?text='.urlencode("主人，".$staff_name."又访问服务器啦~"));*/
            //服务器监控
            $SENDKEY = "7326-4b78d27b731b015a62d1c4c00361e10e";
            $header = $staff_name."正在登陆系统……";
            $content = "系统日志";
            file_get_contents('https://pushbear.ftqq.com/sub?sendkey='.$SENDKEY.'&text='.urlencode($header).'&desp='.urlencode($content));
        }

        // 从分公司指标表里查询数据
        $result= Db::query('select * from helc_sdcompanyindex where year = "2018"
ORDER BY sign_complete,install_rate,pre_intoforce,pre_sign
');
        $result2= Db::query('select * from helc_sdquarterindex
');
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
        //欠款合计
        $result6= Db::query('
SELECT company,FORMAT(arrears_amount,0) AS arrears_amount,FORMAT(arrears_amount1,0) AS arrears_amount1,FORMAT(total,0) AS total,total AS total1 FROM(SELECT IFNULL(company,\'合计\') AS company,SUM(arrears_amount) AS arrears_amount,SUM(arrears_amount1)AS arrears_amount1,SUM(arrears_amount+arrears_amount1) AS total 
FROM(SELECT company,IFNULL(arrears_amount4,0)-IFNULL(eq_recovery,0)+IFNULL(arrears_amount1,0) AS arrears_amount,IFNULL(arrears_amount5,0)-IFNULL(in_recovery,0)+IFNULL(arrears_amount2,0) AS arrears_amount1 FROM(SELECT * FROM(SELECT * FROM(SELECT * FROM(SELECT * FROM(SELECT SUBSTR(company,1,2) as company,SUM(arrears_amount) AS arrears_amount
FROM helc_arrears
GROUP BY company) AS A
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company1,SUM(arrears_amount) AS arrears_amount1
FROM helc_arrears
WHERE expire_date >= \'2018-04-01\' AND arrears_type=\'设备欠款\'
GROUP BY company) AS B 
ON A.company = B.company1) AS C
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company2,SUM(arrears_amount) AS arrears_amount2
FROM helc_arrears
WHERE expire_date >= \'2018-04-01\' AND arrears_type=\'安装欠款\'
GROUP BY company) AS D
ON C.company = D.company2) AS E
LEFT JOIN 
(SELECT company AS company3,split_amount1 AS eq_recovery,split_amount2 AS in_recovery FROM(SELECT * FROM(SELECT SUBSTR(company,1,2) AS company,SUM(split_amount) AS split_amount
FROM helc_income
GROUP BY company) AS H
LEFT JOIN
(SELECT SUBSTR(company,1,2) AS company1,SUM(split_amount) AS split_amount1
FROM helc_income
WHERE classification = \'销售收款\'  AND arrears_type = \'历史欠款\'
GROUP BY company1) AS I
ON H.company = I.company1) AS J
LEFT JOIN
(SELECT SUBSTR(company,1,2) AS company2,SUM(split_amount) AS split_amount2
FROM helc_income
WHERE classification = \'安装收款\' AND arrears_type = \'历史欠款\'
GROUP BY company2) AS K
ON J.company = K.company2) AS F
ON E.company = F.company3) AS L
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company4,SUM(arrears_amount) AS arrears_amount4
FROM helc_arrears
WHERE expire_date < \'2018-04-01\' AND arrears_type=\'设备欠款\'
GROUP BY company) AS M
ON L.company = M.company4) AS N
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company5,SUM(arrears_amount) AS arrears_amount5
FROM helc_arrears
WHERE expire_date < \'2018-04-01\' AND arrears_type=\'安装欠款\'
GROUP BY company) AS O
ON N.company = O.company5) AS P
GROUP BY company WITH ROLLUP) AS Q
ORDER BY total1
');
        //当年欠款
        $result7= Db::query('SELECT company,arrears_amount,arrears_amount1,total,convert(IFNULL(contract_amount,0), decimal(12,2)) AS contract_amount,CONCAT(ROUND(total*100/contract_amount, 2),\'\',\'%\')  AS rate FROM (SELECT IFNULL(company,\'合计\') AS company,convert(SUM(IFNULL(arrears_amount1,0)), decimal(12,2)) AS arrears_amount,convert(SUM(IFNULL(arrears_amount2,0)), decimal(12,2)) AS arrears_amount1,convert(SUM(IFNULL(arrears_amount1,0)+IFNULL(arrears_amount2,0)), decimal(12,2)) AS total 
FROM(SELECT * FROM(SELECT * FROM (SELECT SUBSTR(company,1,2) as company,SUM(arrears_amount) AS arrears_amount
FROM helc_arrears
GROUP BY company) AS A
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company1,SUM(arrears_amount) AS arrears_amount1
FROM helc_arrears
WHERE expire_date >= \'2018-04-01\' AND arrears_type=\'设备欠款\'
GROUP BY company) AS B
ON A.company = B.company1) AS C
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company2,SUM(arrears_amount) AS arrears_amount2
FROM helc_arrears
WHERE expire_date >= \'2018-04-01\' AND arrears_type=\'安装欠款\'
GROUP BY company) AS D
ON C.company = D.company2) AS E
GROUP BY company WITH ROLLUP) AS F
LEFT JOIN
(SELECT SUBSTR(company,1,2) as company3,contract_amount
FROM helc_sdcompanyindex
WHERE `year` = 2018) AS G
ON F.company = G.company3
ORDER BY total
');
        //区域在制
        $result8= Db::query('SELECT IFNULL(SUBSTR(company,1,2),\'合计\') AS company,SUM(making) AS making,SUM(making1) AS making1,SUM(making2) AS making2,SUM(entry) AS entry FROM(SELECT * FROM(SELECT * FROM (SELECT helc_responsible.company,COUNT(product_id) AS making
FROM helc_product,helc_responsible
WHERE helc_product.supervisor= helc_responsible.name AND complete_date =\'0000-00-00\' AND delivery_date>0
GROUP BY company )AS A
LEFT JOIN
(SELECT helc_responsible.company AS company1,COUNT(product_id) AS making1
FROM helc_product,helc_responsible
WHERE helc_product.supervisor= helc_responsible.name AND complete_date =\'0000-00-00\' AND delivery_date>0 AND TO_DAYS(NOW()) - TO_DAYS(delivery_date)<=180
GROUP BY company ) AS B
ON A.company = B.company1) AS D
LEFT JOIN 
(SELECT helc_responsible.company AS company2,COUNT(product_id) AS making2
FROM helc_product,helc_responsible
WHERE helc_product.supervisor= helc_responsible.name AND complete_date =\'0000-00-00\' AND delivery_date>0 AND TO_DAYS(NOW()) - TO_DAYS(delivery_date)>=365
GROUP BY company ) AS C
ON D.company = C.company2) AS E
LEFT JOIN
(SELECT helc_responsible.company AS company3,COUNT(product_id) AS entry
FROM helc_product,helc_responsible
WHERE helc_product.supervisor= helc_responsible.name AND entry_date BETWEEN \'2018-04-01\' AND \'2019-03-31\' AND complete_date=\'0000-00-00\'
GROUP BY company ) AS F
ON E.company = F.company3
GROUP BY company WITH ROLLUP
');
        //维保台量
        $result9= Db::query('SELECT SUBSTR(company,1,2) AS company,total,guarantee,paid,paid_index,CONCAT(paid_per,"%") AS paid_per
FROM helc_maintain
');
        //保养销售入金
        $result10= Db::query('SELECT SUBSTR(company,1,2) AS company,maintain_sale_index,maintain_sale,maintain_sale_per,maintain_income_index,maintain_income,maintain_income_per
FROM helc_maintain
');
        //安装历史欠款与回
        $result11= Db::query('
SELECT company,convert(arrears_amount, decimal(12,2)) AS arrears_amount,convert(split_amount, decimal(12,2)) AS split_amount,convert(balance, decimal(12,2)) AS balance,CONCAT(ROUND(split_amount/ arrears_amount * 100, 2),\'\',\'%\') AS income_per FROM(SELECT IFNULL(company,\'合计\') AS company,SUM(arrears_amount) AS arrears_amount,SUM(IFNULL(split_amount,0))AS split_amount,SUM(arrears_amount-IFNULL(split_amount,0)) AS balance FROM(SELECT SUBSTR(company,1,2) AS company,SUM(arrears_amount) AS arrears_amount
FROM helc_arrears
WHERE arrears_type = \'安装欠款\' AND expire_date < \'2018-04-01\'
GROUP BY company) AS A
LEFT JOIN 
(SELECT SUBSTR(company,1,2) AS company1,SUM(split_amount) AS split_amount
FROM helc_income
WHERE arrears_type = \'历史欠款\' AND classification = \'安装收款\'
GROUP BY company1) AS B
ON A.company = B.company1
GROUP BY company WITH ROLLUP) AS A
ORDER BY balance
');
        //设备历史欠款与回收
        $result12= Db::query('
SELECT company,convert(arrears_amount, decimal(12,2)) AS arrears_amount,convert(split_amount, decimal(12,2)) AS split_amount,convert(balance, decimal(12,2)) AS balance,CONCAT(ROUND(split_amount/ arrears_amount * 100, 2),\'\',\'%\') AS income_per FROM(SELECT IFNULL(company,\'合计\') AS company,SUM(arrears_amount) AS arrears_amount,SUM(IFNULL(split_amount,0))AS split_amount,SUM(arrears_amount-IFNULL(split_amount,0)) AS balance FROM(SELECT SUBSTR(company,1,2) AS company,SUM(arrears_amount) AS arrears_amount
FROM helc_arrears
WHERE arrears_type = \'设备欠款\' AND expire_date < \'2018-04-01\'
GROUP BY company) AS A
LEFT JOIN 
(SELECT SUBSTR(company,1,2) AS company1,SUM(split_amount) AS split_amount
FROM helc_income
WHERE arrears_type = \'历史欠款\' AND classification = \'销售收款\'
GROUP BY company1) AS B
ON A.company = B.company1
GROUP BY company WITH ROLLUP) AS A
ORDER BY balance
');
        //维改销售入金
        $result13= Db::query('SELECT SUBSTR(company,1,2) AS company,repair_sale_index,repair_sale,repair_sale_per,repair_income_index,repair_income,repair_income_per
FROM helc_maintain
');
        //欠款原因
        $result14= Db::query('SELECT company,convert(notcollect, decimal(12,2)) AS notcollect,convert(pending, decimal(12,2)) AS pending,convert(sublawsuit, decimal(12,2)) AS sublawsuit,convert(notexpired, decimal(12,2)) AS notexpired,convert(inprocess, decimal(12,2)) AS inprocess,convert(notcollect+pending+sublawsuit+notexpired+inprocess, decimal(12,2)) AS total FROM(SELECT IFNULL(SUBSTR(company,1,2),\'合计\') AS company,SUM(notcollect) AS notcollect,SUM(pending) AS pending,SUM(sublawsuit) AS sublawsuit,SUM(notexpired) AS notexpired,SUM(inprocess) AS inprocess
FROM helc_reason
GROUP BY company WITH ROLLUP) AS A
ORDER BY total
');
        //保养成本
        $result15= Db::query('SELECT SUBSTR(company,1,2) AS company,guarantee_ave_year,new_ave_year,maintain_cost_single,gross_profit_margin
FROM helc_maintain
');
        //季度完工
        $result16= Db::query('select * from helc_sdquarterindex
');
        //事业部总体得分
        if ($company=='山东分公司') {
            $result17= Db::query('SELECT rank,bu_sname,FORMAT(intoforce,2) AS intoforce,FORMAT(complete,2) AS complete,FORMAT(thisyear,2) AS thisyear,convert(history, decimal(12,2)) AS history,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buscore WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result17= Db::query("SELECT rank,bu_sname,intoforce,complete,thisyear,history,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buscore WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部生效得分
        if ($company=='山东分公司') {
            $result18= Db::query('SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buintoforce WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result18= Db::query("SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buintoforce WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部完工得分
        if ($company=='山东分公司') {
            $result19= Db::query('SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_bucomplete WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result19= Db::query("SELECT rank,bu_sname,year_index,year_complete,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_bucomplete WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部当年欠款得分
        if ($company=='山东分公司') {
            $result20= Db::query('SELECT rank,bu_sname,convert(contract_amount, decimal(12,2)) AS contract_amount,convert(this_arrears, decimal(12,2)) AS this_arrears,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buthisyear WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result20= Db::query("SELECT rank,bu_sname,convert(contract_amount, decimal(12,2)) AS contract_amount,convert(this_arrears, decimal(12,2)) AS this_arrears,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buthisyear WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //事业部历史欠款得分
        if ($company=='山东分公司') {
            $result21= Db::query('SELECT rank,bu_sname,convert(arrears, decimal(12,2)) AS arrears,convert(recovery, decimal(12,2)) AS recovery,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buarrears WHERE year=2018 AND status = 1 ORDER BY score DESC
');

        }else{
            $result21= Db::query("SELECT rank,bu_sname,convert(arrears, decimal(12,2)) AS arrears,convert(recovery, decimal(12,2)) AS recovery,FORMAT(rate,2) AS rate,convert(score, decimal(12,2)) AS score,SUBSTR(company,1,2) AS company FROM helc_buarrears WHERE company='$company' AND year=2018 AND status = 1 ORDER BY score DESC
");

        }
        //竞争对手下浮
        $result22= Db::query('SELECT rivals,quote_date,elevator_model,relative_float*100 AS relative_float,helc_rivals.quote_id AS quote_id,quote_num,city,SUBSTR(project_name,1,15) AS project_name FROM `helc_rivals`,helc_quote
WHERE helc_rivals.quote_id = helc_quote.quote_id AND quote_date>=DATE_SUB(CURRENT_DATE() , INTERVAL 3 MONTH)
ORDER BY quote_date,city;
');
        //生效客户分析
        $result23= Db::query('SELECT company,sum1,sum2,sum,CONCAT(ROUND(sum2/sum * 100, 2),\'\',\'%\') AS per FROM(SELECT IFNULL(company,\'合计\') AS company,SUM(sum1) AS sum1,SUM(IFNULL(sum2,0)) AS sum2,SUM(sum1+IFNULL(sum2,0)) AS sum FROM(SELECT SUBSTR(belong_to,1,2) AS company,COUNT(product_id) AS sum1 FROM `helc_product`,helc_contract
WHERE helc_product.contract_id=helc_contract.contract_id AND client_attributes = \'普通\' AND `status` = \'正常\' AND  into_force_date BETWEEN \'2018-04-01\' AND \'2019-03-31\'
GROUP BY belong_to) AS A
LEFT JOIN
(SELECT SUBSTR(belong_to,1,2) AS company1,COUNT(product_id) AS sum2 FROM `helc_product`,helc_contract
WHERE helc_product.contract_id=helc_contract.contract_id AND client_attributes = \'大客户\' AND `status` = \'正常\' AND  into_force_date BETWEEN \'2018-04-01\' AND \'2019-03-31\'
GROUP BY belong_to) AS B
ON A.company= B.company1
GROUP BY company WITH ROLLUP) AS C
ORDER BY sum
');
        //签梯均价
        $result24= Db::query('SELECT IFNULL(company,\'合计\') as company,FORMAT(sum1/cou1,2) AS 17eq,FORMAT(sum2/cou2,2) AS 18eq,FORMAT(sum3/cou1,2) AS 17in,FORMAT(sum4/cou2,2) AS 18in FROM(SELECT SUBSTR(belong_to,1,2) AS company,SUM(sum1) AS sum1,SUM(sum3) AS sum3,SUM(cou1) AS cou1,SUM(sum2) AS sum2,SUM(sum4) AS sum4,SUM(cou2) AS cou2 FROM
(SELECT belong_to,SUM(contract_equipment_price) AS sum1,SUM(contract_installation_price) AS sum3,COUNT(product_id) AS cou1 FROM helc_product
WHERE into_force_date BETWEEN \'2017-04-01\' AND \'2018-03-31\'
GROUP BY belong_to) AS A
LEFT JOIN
(SELECT belong_to AS belong_to1,SUM(contract_equipment_price) AS sum2,SUM(contract_installation_price) AS sum4,COUNT(product_id) AS cou2 FROM helc_product
WHERE into_force_date BETWEEN \'2018-04-01\' AND \'2019-03-31\'
GROUP BY belong_to) AS B
ON A.belong_to = B.belong_to1
GROUP BY company WITH ROLLUP) AS C
');


        // 向V层传数据
        $this->assign('result', $result);
        $this->assign('result2', $result2);
        $this->assign('result3', $result3);
        $this->assign('result4', $result4);
        $this->assign('result5', $result5);
        $this->assign('result6', $result6);
        $this->assign('result7', $result7);
        $this->assign('result8', $result8);
        $this->assign('result9', $result9);
        $this->assign('result10', $result10);
        $this->assign('result11', $result11);
        $this->assign('result12', $result12);
        $this->assign('result13', $result13);
        $this->assign('result14', $result14);
        $this->assign('result15', $result15);
        $this->assign('result16', $result16);
        $this->assign('result17', $result17);
        $this->assign('result18', $result18);
        $this->assign('result19', $result19);
        $this->assign('result20', $result20);
        $this->assign('result21', $result21);
        $this->assign('result22', $result22);
        $this->assign('result23', $result23);
        $this->assign('result24', $result24);
        $this->display();
        $htmls = $this->fetch();
        return $htmls;
    }
    /*excel导出*/
    function exportExcel($expTitle,$expCellName,$expTableData){
        /*include_once (EXTEND_PATH.'PHPExcel/PHPExcel.php');//方法二*/
        vendor("PHPExcel.PHPExcel");
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        //$objPHPExcel = new PHPExcel();//方法一
        $objPHPExcel = new \PHPExcel();//方法二
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\".xls");
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        //$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
        $objWriter->save('php://output');
        exit;
    }
    /**
     * 导出Excel
     * @param  object $spreadsheet  数据
     * @param  string $format       格式:excel2003 = xls, excel2007 = xlsx
     * @param  string $savename     保存的文件名
     * @return filedownload         浏览器下载
     */
    function Excel($spreadsheet, $format = 'xls', $savename = 'export') {
        if (!$spreadsheet) return false;
        if ($format == 'xls') {
            //输出Excel03版本
            header('Content-Type:application/vnd.ms-excel');
            $class = "\PhpOffice\PhpSpreadsheet\Writer\Xls";
        } elseif ($format == 'xlsx') {
            //输出07Excel版本
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $class = "\PhpOffice\PhpSpreadsheet\Writer\Xlsx";
        }
        //输出名称
        header('Content-Disposition: attachment;filename="'.$savename.'.'.$format.'"');
        //禁止缓存
        header('Cache-Control: max-age=0');
        $writer = new $class($spreadsheet);
        $filePath = env('runtime_path')."temp/".time().microtime(true).".tmp";
        $writer->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }
}

class Office
{
    /**
     * 导出excel表
     * $data：要导出excel表的数据，接受一个二维数组
     * $name：excel表的表名
     * $head：excel表的表头，接受一个一维数组
     * $key：$data中对应表头的键的数组，接受一个一维数组
     * 备注：此函数缺点是，表头（对应列数）不能超过52；
     *循环不够灵活，一个单元格中不方便存放两个数据库字段的值
     */
    public function outdata($name,$head = [],$data = [],$keys = [])
    {

        $count = count($head);  //计算表头数量
        $xlsTitle = iconv('utf-8', 'gb2312', $name);//文件名称
        $fileName = $name.date('_YmdHis');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        set_time_limit(0);
            $key = ord("A");
            $key2 = ord("@");//@--64
            foreach($head as $v){
                if($key>ord("Z")){
                    $key2 += 1;
                    $key3 = ord("A");
                    $colum = chr($key3).chr($key2);//超过26个字母时才会启用
                }else{
                    if($key2>=ord("A")){
                        $colum = chr($key2).chr($key);
                    }else{
                        $colum = chr($key);
                    }
                }
                $sheet->setCellValue($colum. '1', $head[$key - 65]);
                $key += 1;
            }
        /*--------------开始从数据库提取信息插入Excel表中------------------*/
        $column = 2;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
		    $span2 = ord("@");
            foreach($head as $k=>$v){
                if($span>ord("Z")){
                    $span2 += 1;
                    $span3 = ord("A");
                    $j = chr($span3).chr($span2);//超过26个字母时才会启用
                }else{
                    if($span2>=ord("A")){
                        $j = chr($span2).chr($span);
                    }else{
                        $j = chr($span);
                    }
                }
                $sheet->setCellValue($j. $column, $rows[$keys[$span - 65]]);
                $span++;
            }
		$column++;
	    }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        //删除清空：
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);
        exit;
    }
}