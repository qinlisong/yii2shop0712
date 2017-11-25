<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 16:04
 */

namespace frontend\controllers;


use frontend\models\Cart;
use frontend\models\LoginForm;
use frontend\models\Member;
use Mrgoon\AliSms\AliSms;
use yii\web\Controller;
use yii\web\Request;

class MemberController extends Controller
{
    public $layout = "reg";

//    public function actionReg()
//    {
//        $model = new Member();
//        return $this->render('reg', ['model' => $model]);
//    }
//关闭csrf
    public function init(){
        $this->enableCsrfValidation = false;
    }

    public function actionIndex()
    {
        $member = Member::find()->all();
        return $this->render("index", ['member' => $member]);
    }

    public function actionReg()
    {
        $model = new Member();
        $request = \Yii::$app->request;
        //判断是不是post请求
        if ($request->isPost) {
            //绑定

            if ($model->load($request->post())&& $model->validate()) {
//                 var_dump($request->post());exit;
                //密码加密
                $model->password = \Yii::$app->security->generatePasswordHash($model->password);
                $model->add_time = time('Y:m:d H:m;s', $model->add_time);
                $model->last_login_time = time('Y:m:d H:m;s', $model->last_login_time);
                $model->status = 0;
//                var_dump($request->post());exit;
                $model->save();

                \Yii::$app->session->setFlash("success", "注册成功");
                return $this->redirect("index");
            } else {
                var_dump($model->getErrors());
                exit;
//                    var_dump($model->getErrors());
            }
        }
//            return $this->render('add', ['model' => $model]);

        return $this->render("reg", ['model' => $model]);
    }

    public function actionLogin()
    {
        $modle = new LoginForm();
        $member =new Member();
        //判断是不是post提交
        $request = \Yii::$app->request;
        if ($request->isPost) {
            $data =$request->post();
            //绑定数据 验证;
          $member->load($data);

                //判断有没有这个用户名
                $admin = Member::findOne(['username' => $member->username]);
                if ($admin) {
                    //存在判断密码
                    if (\Yii::$app->security->validatePassword($member->password, $admin->password)) {
                        \Yii::$app->user->login($admin);
                        //处理购物车同步数据
                        (new \frontend\components\Cart())->synDb()->flush()->save();
                        $admin->save();
                          //跳转
                        return $this->redirect(['index']);

                    } else {
//                var_dump($admin->getErrors());exit;
                        echo \Yii::$app->session->setFlash("danger", "密码错误");
                    }

                } else {
                    //不存在 提示没用用户名
                    $modle->addError("username", "用户名不存在");
                }
            }

        //显示视图
        return $this->render("login", ['modle' => $modle]);


    }

    public function actionSms($mobile)
    {
        $config = [
            'access_key' => 'LTAIhrrtYZBj2UXu',
            'access_secret' => '7XoisWUpuWqVWqfAPLybgHZ7EBvVOq',
            'sign_name' => '小秦',
        ];

        $aliSms = new AliSms();
        $response = $aliSms->sendSms($mobile, 'SMS_111795325', ['code'=> rand(1000,9999)], $config);



    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}