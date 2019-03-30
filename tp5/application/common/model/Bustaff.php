<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/4/23
 * Time: 7:32
 */

namespace app\common\model;

use think\Model;

class Bustaff extends Model
{
    protected $table = 'helc_bustaff';
    /**
     * 判断用户是否已登录
     * @return boolean 已登录true
     * @author  panjie <panjie@yunzhiclub.com>
     */
    static public function isLogin()
    {
        $staff_id = session('staff_id');

        // isset()和is_null()是一对反义词
        if (isset($staff_id)) {
            return true;
        } else {
            return false;
        }
    }
}