<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //得到所有数据
        $cates=GoodsCategory::find();
        $dataProvider = new ActiveDataProvider([
         'query' => $cates,
          'pagination' => false,
      ]);
        return $this->render('index',['cates'=>$cates,'dataProvider'=>$dataProvider]);
    }

    public function actionTest()
    {
      $cate=new GoodsCategory();
      $cate->name='家电';
      $cate->parent_id=0;
      $cate->makeRoot();
      var_dump($cate->getErrors());
}

    public function actionAddChild()
    {
      //创建儿子分类
        $cate=new GoodsCategory();
        $cate->name='冰箱';
        $cate->parent_id=1;
        //把儿子分类加入到家电中
        //找到家电分类的对象
        $cateParent=GoodsCategory::findOne(['id'=>1]);
        $cate->prependTo($cateParent);
}

    public function actionView()
    {
       $modle=new GoodsCategory();
       //判断是不是post提交
        $request=\Yii::$app->request;
        if($request->isPost){
            //绑定数据
            $modle->load($request->post());
            if($modle->validate()){
                //判断父id是不是0 是就创建根目录
                if($modle->parent_id==0){
                    //创建根目录
                    $modle->makeRoot();
//              $modle->save();

                }else{
                    //创建子分类
                    //找到父节点
                    $cateParent=GoodsCategory::findOne(['id'=>$modle->parent_id]);
                    //追加到父节点
                    $modle->prependTo($cateParent);

                }
                \Yii::$app->session->setFlash("success","添加目录成功");
                return $this->redirect(['index']);
            }

        }
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $cates=Json::encode($cates);
       // var_dump($cates);exit;
//        var_dump($cates);exit;
       return $this->render("add",['modle'=>$modle,'cates'=>$cates]);
}

    public function actionUpdate($id)
    {
        $modle=GoodsCategory::findOne($id);

        //判断是不是post提交
        $request=\Yii::$app->request;
        if($request->isPost){

            //绑定数据
            $modle->load($request->post());
//            var_dump($modle);die();
            if($modle->validate()){
              $modle->save();
                \Yii::$app->session->setFlash("success","修改目录成功");
                return $this->redirect(['index']);
            }

        }
        $cates=GoodsCategory::find()->asArray()->all();
        $cates[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $cates=Json::encode($cates);
        // var_dump($cates);exit;
//        var_dump($cates);exit;
        return $this->render("add",['modle'=>$modle,'cates'=>$cates]);
}

    public function actionDelete($id)
    {
//        $cates=GoodsCategory::find()->where(['parent_id'=>$id])->all();
//        var_dump($cates);die();
        $cate=GoodsCategory::findOne($id);
        //删除当前节点和他的子节点
        $cate->deleteWithChildren();
      $this->redirect(['index']);
//        if(!$cate->parent_id==0){
//            $cate->delete();
//        }else{
//
//        }

}
}
