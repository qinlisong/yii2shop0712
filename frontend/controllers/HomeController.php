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
        $cate=GoodsCategory::findOne($id);
        //得到当前分类和子分类  所有子分类比当前分类的左值大  比右值小 同一颗树
       $cates=GoodsCategory::find()->where(['tree'=>$cate['tree']])->andWhere(['>=','lft',$cate->lft])->andWhere(['<=','rgt',$cate->rgt])->asArray()->all();
//       var_dump($cates);exit;
        //把这些分类的id提取出来
       $catesId= array_column($cates,"id");
//        var_dump($catesId);exit;
        //查询商品的分类id在上面提取出来的id中的商品
        $goods=Goods::find()->where(['in','goods_category_id',$catesId])->all();

        return $this->renderPartial("list",['goods'=>$goods]);
}

    public function actionDetail($id)
    {
        $good=Goods::findOne($id);
       return $this->renderPartial("detail",['good'=>$good]);
}

    public function actionAddCart($goodsId,$num)
    {    //避免清空cookie报错
        if(Goods::findOne($goodsId) === NULL){
//            return $this->redirect(['index']);
        }
        //如果没有登录
        if(\Yii::$app->user->isGuest){
            //如果没有登录存在cookie  数据类型数组 [goodsId=>num,goodsId1=>num1]
            $cart=[$goodsId=>$num];

            //获得购物车中已有的coockie数据
            $getCookie=\Yii::$app->request->cookies;
            $cartOld=$getCookie->getValue('cart')?$getCookie->getValue('cart') : [];
//           var_dump($cartOld);
            //判断购物车中有没有当前商品
            if(key_exists($goodsId,$cartOld)){
//           var_dump(key_exists($goodsId,$cartOld));exit;
                //如果存在则修改num的数量
                $cartOld[$goodsId]+=$num;
            }else{
                //不存在则追加
                $cartOld[$goodsId]=$num;
            }
//          var_dump($cartOld);exit;
          //存cookie
            $setCookie=\Yii::$app->response->cookies;
            //设置cookie对象
            $cartCookie= new Cookie([
             'name'=>'cart',//购物车
                'value'=>$cartOld,
                'expire'=>time()+3600*24*7

            ]);
       //把cookie对象加到cookie里面
            $setCookie->add($cartCookie);
            //跳转到购物车页面
            return $this->redirect(['cart']);
        }else{
            //已经登录 存数据库
        }
}

    public function actionCart()
    {
        if(\Yii::$app->user->isGuest){
            //操作cookie未登录
            $getCookie=\Yii::$app->request->cookies;
            //得到购物车的数据
            $carts=$getCookie->getValue("cart");
//            var_dump($carts);exit;
            $goods=[];
            foreach ($carts as $goodsId=>$num) {
                //得到当前车里的商品
                $good = Goods::find()->where(['id' => $goodsId])->asArray()->one();
                $good['num'] = $num;
                $goods[] = $good;


            }
//            var_dump($goods);exit;
        }








//      var_dump($goods);exit;
       return $this->renderPartial("cart",['goods'=>$goods]);
}

    public function actionChangeCart(){
        $request=\Yii::$app->request;
        //接收参数
        $id=$request->post('id');
        $num=$request->post('num');
        //如果没有登录
        if (\Yii::$app->user->isGuest){
            $getCookie=\Yii::$app->request->cookies;
            //取出Cookie
            $cart=$getCookie->getValue('cart');
            // return Json::encode($cart);
            $cart[$id]=$num;
            $setCookie=\Yii::$app->response->cookies;
            $cartCookie=new Cookie(
                [
                    'name'=>"cart",
                    'value'=>$cart,
                    'expire'=>time()+3600
                ]
            );
            $setCookie->add($cartCookie);
        }
        //如果登录
    }

    public function actionTest()
    {
        //得到cookie数据
        $getCookie=\Yii::$app->request->cookies;
        var_dump($getCookie->getValue('cart'));
}
}