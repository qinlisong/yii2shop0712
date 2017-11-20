<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 19:14
 */

namespace frontend\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionSms()
    {

        $config = [
            'access_key' => 'LTAIhrrtYZBj2UXu',
            'access_secret' => '7XoisWUpuWqVWqfAPLybgHZ7EBvVOq',
            'sign_name' => 'qinlisong',
        ];
          $sms=new AliSms();

        $response = $sms->sendSms('15696246641', 'tempplate code', ['name'=> 'value in your template'], $config);
}
}