<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/20
 * Time: 10:39
 */

namespace app\index\controller;
use app\common\model\Orgstructure;
use think\Controller;
use think\Request;

class OrgstructureController extends IndexController
{
    public function index(){
        // 获取组织架构表中的所有数据
        $Orgstructure = new Orgstructure;
        $orgstructures = $Orgstructure->select();

        // 向V层传数据
        $this->assign('orgstructures', $orgstructures);

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

        // 实例化Teacher空对象
        $Orgstructure = new Orgstructure();

        // 为对象赋值
        $Orgstructure->org_name = $postData['org_name'];
        $Orgstructure->org_id = $postData['org_id'];
        $Orgstructure->org_level = $postData['org_level'];
        $Orgstructure->parent_id = $postData['parent_id'];

        // 新增对象至数据表
        $result = $Orgstructure->save();

        // 反馈结果
        if (false === $result)
        {
            // 验证未通过，发生错误
            $message = '新增失败:' . $Orgstructure->getError();
        } else {
            // 提示操作成功，并跳转至教师管理列表
            return $this->success('新增成功', url('index'));
        }
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

}