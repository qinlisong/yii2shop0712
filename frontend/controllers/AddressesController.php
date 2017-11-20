<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 14:53
 */

namespace frontend\controllers;


use frontend\models\Addresses;
use yii\web\Controller;

class AddressesController extends Controller
{
    public $layout = "login";

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionAdd()
    {
        $model = new Addresses();
        $request=\Yii::$app->request;
        if($request->isPost){
//            var_dump($request->post());exit;

        }
        return $this->render("add", ['model' => $model]);
    }
}