<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19
 * Time: 15:49
 */

namespace frontend\controllers;


use backend\models\Goods;
use backend\models\GoodsCategory;
use frontend\components\Cart;
use yii\web\Controller;
use yii\web\Cookie;

class HomeController extends  Controller
{
    public function actionIndex()
    {
        return $this->renderPartial("index");
    }

    public function actionList($id)
    {   //当前分类
        $cate = GoodsCategory::findOne($id);
        //得到当前分类和子分类  所有子分类比当前分类的左值大  比右值小 同一颗树
        $cates = GoodsCategory::find()->where(['tree' => $cate['tree']])->andWhere(['>=', 'lft', $cate->lft])->andWhere(['<=', 'rgt', $cate->rgt])->asArray()->all();
//       var_dump($cates);exit;
        //把这些分类的id提取出来
        $catesId = array_column($cates, "id");
//        var_dump($catesId);exit;
        //查询商品的分类id在上面提取出来的id中的商品
        $goods = Goods::find()->where(['in', 'goods_category_id', $catesId])->all();

        return $this->renderPartial("list", ['goods' => $goods]);
    }

    public function actionDetail($id)
    {
        $good = Goods::findOne($id);

        return $this->renderPartial("detail", ['good' => $good]);
    }

    public function actionAddCart($goodsId, $num)
    {    //避免清空cookie报错
        if (Goods::findOne($goodsId) === NULL) {
//            return $this->redirect(['index']);
        }
//        var_dump($num);die();
        //如果没有登录
        if (\Yii::$app->user->isGuest) {

            $cart= new Cart();
            $cart->add($goodsId,$num);
            $cart->save();

            //跳转到购物车页面
            return $this->redirect(['cart']);
        } else {
            //已经登录 存数据库
            $memberId=\Yii::$app->user->id;
            //通过用户id和商品id得到购物车商品
            $carts=\frontend\models\Cart::find()->where(['goods_id'=>$goodsId,'member_id'=>$memberId])->one();
        if($carts === null){

            //执行添加操作
            $cart=new \frontend\models\Cart();
            $cart->goods_id=$goodsId;
            $cart->member_id=$memberId;
            $cart->num=$num;
            $cart->save();
        }else{
//            var_dump($num);die();
            //修改
            $carts->num+=$num;
            $carts->save();
        }
//   var_dump($cart);exit;
     return $this->redirect(['cart']);
        }
    }

    public function actionCart()
    {
        if (\Yii::$app->user->isGuest) {
            //操作cookie未登录
            $getCookie = \Yii::$app->request->cookies;
            //得到购物车的数据
            $carts = $getCookie->has("cart") ? $getCookie->getValue("cart") : [];
//            var_dump($carts);exit;
            $goods = [];
            foreach ($carts as $goodsId => $num) {
                //得到当前车里的商品
                $good = Goods::find()->where(['id' => $goodsId])->asArray()->one();
                $good['num'] = $num;
                $goods[] = $good;
            }
        } else {
            $memberId = \Yii::$app->user->id;
            //var_dump($memberId);exit();
            //已登录   数据库得到所有商品
            $carts = \frontend\models\Cart::find()->where(['member_id' => $memberId])->asArray()->all();
   //var_dump($carts);exit;
            $goods=[];
            foreach ($carts as $k => $v) {
                //得到当前车里的商品
                $good = Goods::find()->where(['id' => $v['goods_id']])->asArray()->one();
                $good['num'] = $v['num'];
                $goods[] = $good;
            }
//            var_dump($goods);exit();
            return $this->renderPartial('cart', compact('goods'));
        }
    }
    /**
     * 专用用来做AJax
     */
    public function actionAjax($type)
    {
        switch ($type){
            case "change":
                $request = \Yii::$app->request;
                //接收参数
                $id = $request->post('id');
                $num = $request->post('num');
                //如果没有登录
//                var_dump($id);exit();
                if (\Yii::$app->user->isGuest) {
                    \Yii::$app->cart->update($id,$num)->save();
                }
                //如果登录
                break;
            //如果删除操作
            case "del":
                //var_dump(11);exit();
                $request = \Yii::$app->request;
                //接收参数
                $id = $request->post('id');
                //判断是否登录

                if (\Yii::$app->user->isGuest){
//                    $cart=new Cart();
//                     $cart->del($id)->save();
                    (new Cart())->del($id)->save();
                }else{
                    //已登录
                }
                return "success";
                break;
        }
    }

}