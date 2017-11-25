<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 19:06
 */

namespace frontend\controllers;
use EasyWeChat\Payment\Order;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Url\Url;
use yii\web\Controller;

class PayController extends Controller
{
    public function actionPay()
    {
//        echo 111 ; exit;

        $app = new Application(\Yii::$app->params['wechatOption']);
        $payment = $app->payment;
//        var_dump($payment);die();
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => '京西商城订单',
            'detail'           => '手机',
            'out_trade_no'     => '1246345633',//订单号
            'total_fee'        => 1, // 单位：分
            'notify_url'       =>\yii\helpers\Url::to(['ok'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
//            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new Order($attributes);

        $result = $payment->prepare($order);
        var_dump($result);exit;
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
        }
        var_dump($result);
}

    public function actionTest()
    {
         echo \yii\helpers\Url::to(['ok'],true);
}
}