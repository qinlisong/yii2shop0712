<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/4
 * Time: 15:49
 */

namespace backend\controllers;


use backend\models\ArticleCategoty;
use yii\web\Controller;

class ArticleCategotyController extends Controller
{
    public function actionIndex()
    {
        $cates=ArticleCategoty::find()->all();
//        var_dump($cates);exit;
       return $this->render('index',['cates'=>$cates]);
   }

    public function actionAdd()
    {
        //制作一个模型得到添加数据
        $cates=new ArticleCategoty();
        $cates->status=1;
        $request=\Yii::$app->request;
        if($cates->load($request->post())){
            if($cates->validate()){
                $cates->save();
                return $this->redirect(['index']);
            }else{
                $cates->getErrors("danger");
            }
        }
        //显示视图
        return $this->render('add',['cates'=>$cates]);
   }

    public function actionEdit($id)
    {
        //制作一个模型得到添加数据
//        $cates=new ArticleCategoty();
        $cates=ArticleCategoty::findOne($id);
        $request=\Yii::$app->request;
        if($cates->load($request->post())){
            if($cates->validate()){
                $cates->save();
                return $this->redirect(['index']);
            }else{
                $cates->getErrors("danger");
            }
        }
        //显示视图
        return $this->render('add',['cates'=>$cates]);
   }

    public function actionDel($id)
    {
        $cates=ArticleCategoty::findOne($id);
        $cates->delete();
        return $this->redirect(['index']);
   }
}