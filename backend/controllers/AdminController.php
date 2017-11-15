<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\LoginForm;

class AdminController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //echo 111;exit;
        $admins=Admin::find()->all();
        return $this->render('index',['admins'=>$admins]);
    }

//        var_dump($admin);exit;
    public function actionAdd()
    {
        $admin=new Admin();
         // 先赋值一个死的
//        $admin->username="admin";
//        $admin->password_hash="123456";
//        $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);
        //随机字符串
//        $admin->auth_key=\Yii::$app->security->generateRandomString();
//        $admin->save();
        //加密
        //接收request的请求
        $request=\Yii::$app->request;
        //判断是不是post请求
        if($request->isPost){
            //绑定
            if($admin->load($request->post())){

//                验证
                if($admin->validate()){
//                    var_dump($admin->validate());exit;
                    $admin->token_create_time=time();
                    $admin->add_time=time();
                    $admin->last_login_time=time();
                    //随机数生成的自动登录令牌
                    $admin->auth_key=\Yii::$app->security->generateRandomString();
                    //密码加密
                    $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);

//                    var_dump($admin);exit;
                    $admin->save();

//                    //找到角色对象
//                    $auth=\Yii::$app->authManager;
//                    //得到admin角色
//                    $role=$auth->getRole('admin');
//                    //把当前用户对象追加到admin橘色中
//                    $auth->assign($role,$admin->id);

//                   var_dump($admin->getErrors());exit;
                    \Yii::$app->session->setFlash("success","注册成功");
                    return $this->redirect("index");
                }else{
                   var_dump($admin->getErrors());exit;
//                    var_dump($admin->getErrors());
                }
            }
        }
        return $this->render('add',['admin'=>$admin]);
    }

    //编辑
    public function actionEdit($id)
    {
       $admin=Admin::findOne($id);
        $request=\Yii::$app->request;
        //判断是不是post请求
        if($request->isPost){
            //绑定
            if($admin->load($request->post())){

//                验证
                if($admin->validate()){
//                    var_dump($admin->validate());exit;
                    $admin->token_create_time=time();
                    $admin->add_time=time();
                    $admin->last_login_time=time();
                    //随机数生成的自动登录令牌
                    $admin->auth_key=\Yii::$app->security->generateRandomString();
                    //密码加密
                    $admin->password_hash=\Yii::$app->security->generatePasswordHash($admin->password_hash);

//                    var_dump($admin);exit;
                    $admin->save();
//                   var_dump($admin->getErrors());exit;
                    \Yii::$app->session->setFlash("success","编辑成功");
                    return $this->redirect("index");
                }else{
                    var_dump($admin->getErrors());exit;
//                    var_dump($admin->getErrors());
                }
            }
        }
        return $this->render('add',['admin'=>$admin]);
    }


    //删除
    public function actionDel($id)
    {
        $admin=Admin::findOne($id);
        $admin->delete();
        \Yii::$app->session->setFlash("success","删除成功");
        return $this->redirect("index");
    }
    //管理员登录

    public function actionLogin()
    {

     $modle=new LoginForm();
     //判断是不是post提交
        $request=\Yii::$app->request;
        if($request->isPost){
           //绑定数据 验证
            if($modle->load($request->post()) && $modle->validate()){
                //判断有没有这个用户名
                $admin=Admin::findOne(['username'=>$modle->username]);
        if($admin){
              //存在判断密码
            //var_dump($modle->password,$admin->password_hash);exit();
            //var_dump(\Yii::$app->security->validatePassword($modle->password,$admin->password_hash));exit();
            if(\Yii::$app->security->validatePassword($modle->password,$admin->password_hash)){
//               $admin->getErrors();exit;
                //执行登录
                \Yii::$app->user->login($admin,$modle->rememberMe?3600*24*7:0);
                //记录最后登录的ip和时间
                $admin->last_login_ip=$_SERVER['REMOTE_ADDR'];
                $admin->last_login_time=time();
               $admin->save();


                //跳转
                return $this->redirect(['index']);

            }else{
//                var_dump($admin->getErrors());exit;
               echo \Yii::$app->session->setFlash("danger","密码错误");
            }

        }else{
            //不存在 提示没用用户名
            $modle->addError("username","用户名不存在");
        }
 }
            }
     //显示视图
        return $this->render("login", ['modle' => $modle]);
    }
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}
