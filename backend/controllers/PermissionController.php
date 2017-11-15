<?php

namespace backend\controllers;

use backend\models\AuthItem;

class PermissionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //实例化RBAC组件
        $authManager=\Yii::$app->authManager;
        //显示权限把所有的权限显示出来
        $permissions=$authManager->getPermissions();
//        var_dump($permission);exit;
        return $this->render("index",['permissions'=>$permissions]);
    }


//权限添加
    public function actionAdd()
    {
       $model=new AuthItem();
       $request=\Yii::$app->request;
           if($model->load($request->post()) && $model->validate()){
                         //brac组件
                         $authManager=\Yii::$app->authManager;
                         //创建权限
                         $permission=$authManager->createPermission($model->name);
                         //添加描述
                       $permission->description=$model->description;
                       //添加权限 吧权限添加到数据库
//                    $authManager->add($permission);
                  if( $authManager->add($permission)){
                      \Yii::$app->session->setFlash("success","添加成功");
                      return $this->redirect(['index']);
                  }else{
                      \Yii::$app->session->setFlash("danger","添加失败");
                  }
           }
//        var_dump($model->getErrors());exit;

        return $this->render("add",['model'=>$model]);

    }
//

//编辑权限
    public function actionEdit($name)
    {
        //$model=new  AuthItem();
        $model=AuthItem::findOne($name);
        $request=\Yii::$app->request;
        if ($model->load($request->post()) && $model->validate()){
            //实例化RBAC组件
            $authManager=\Yii::$app->authManager;
            //找出当前权限对象
            // $permission=$authManager->createPermission($model->name);
            $permission=$authManager->getPermission($model->name);
            if ($permission){
                //添加描述
                $permission->description=$model->description;
                //修改权限 把权限修改到数据库
                $authManager->update($model->name,$permission);
                \Yii::$app->session->setFlash("success","修改".$model->description."成功");
                return $this->redirect(['index']);
            }else{
                \Yii::$app->session->setFlash("danger","不能修改权限名称".$model->name);
                return $this->refresh();
            }
        }
        //var_dump($model->getErrors());exit;
        return $this->render("add",compact('model'));
    }
//权限删除
    public function actionDel($name)
    {
        $auth=\Yii::$app->authManager;
        //找到要删除的权限对象
        $permission=$auth->getPermission($name);
        //删除权限
        if($auth->remove($permission)){
            \Yii::$app->session->setFlash("success","删除成功");
            return $this->redirect(['index']);
        }
}
}
