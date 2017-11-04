<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/4
 * Time: 14:21
 */

namespace backend\controllers;


use backend\models\Article;
//use backend\models\Articlecate;
use backend\models\ArticleCategoty;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    public function actionIndex()
    {
      //接收文件数据
        $articles=Article::find()->all();
        //显示视图
        return $this->render('index',['articles'=>$articles]);

}

    public function actionAdd()
    {
        //增加一个数据模型
        $articles=new Article();
        //默认状态
        $articles->status=1;
        $request=new Request();
        //绑定数据
        if($articles->load($request->post())){
            if($articles->validate()){
//                $articles->inputtime=time();
                $articles->save();
                $this->redirect(['index']);
            }else{
                $articles->addError("出错了");
                //TODO
            }

        }else{
            $articles->addError("出错了");
            //TODO
        }


        //显示视图
        return $this->render("add",['articles'=>$articles]);
}

    public function actionEdit($id)
    {
        //增加一个数据模型
        $articles=Article::findOne($id);
        //默认状态
        $articles->status=1;
        $request=new Request();
        //绑定数据
        if($articles->load($request->post())){
            if($articles->validate()){
//                $articles->inputtime=time();
                $articles->save();
                $this->redirect(['index']);
            }else{
                $articles->addError("出错了");
                //TODO
            }

        }else{
            $articles->addError("出错了");
            //TODO
        }


        //显示视图
        return $this->render("add",['articles'=>$articles]);
}

    public function actionDel($id)
    {
        $articles=Article::findOne($id);
        $articles->delete();
        $this->redirect(['index']);
}


}