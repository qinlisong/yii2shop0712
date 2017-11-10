<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 14:39
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $last_login_time;
    public $username;
    public $password;

    //记住我,默认勾选
    public $rememberMe = true;

    public function rules()
    {
       return [
         [['username','password'],'required'],
           [['rememberMe'],'safe'],
         [['last_login_ip'],'safe']
       ] ;
    }

    public function attributeLabels()
    {
       return[
         'username'=>'用户名' ,
           'password'=>'哈希密码'
       ] ;
    }
}