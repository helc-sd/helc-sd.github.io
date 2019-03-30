<?php
/**
 * Created by PhpStorm.
 * User: Gengchuantao
 * Date: 2018/5/7
 * Time: 7:43
 */
namespace app\common\model;
use think\Model;
class Responsible extends Model{
    protected $table = 'helc_responsible';
    protected $_validate=array(
        //array(验证字段，验证规则，错误提示，验证条件，附加规则，验证时间) 或者单独留给注册用，登陆单独写规则
        array('id','','此工号已经存在！',0,'unique',1),
/*        array('user_name','require','用户名不能为空',self::EXISTS_VALIDATE),
        array('user_name', '5,20', '用户名长度5-20位！', self::EXISTS_VALIDATE,'length'),
        array('password','require','密码不能为空',self::EXISTS_VALIDATE),
        array('code','require','验证码不能为空',self::EXISTS_VALIDATE),
        array('password', '5,30', '密码长度不合法！', self::EXISTS_VALIDATE,'length'),
        array('repassword', 'password', '俩次输入密码不一致！', self::EXISTS_VALIDATE,'confirm'),
        array('code', '4', '请输入4位验证码', self::EXISTS_VALIDATE,'length'),*/
    );
    protected $insertFields = array('id');
}
