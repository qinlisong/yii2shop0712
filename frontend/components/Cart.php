<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 14:49
 */

namespace frontend\components;


use function Sodium\crypto_box_publickey_from_secretkey;
use yii\base\Component;
use yii\web\Cookie;

class Cart extends Component
{
    //设置私有属性用来存储购物车数据
    private  $_cart=[];
    private $expireTime=3600*24*7;
//自动得到cookie的值
public function  __construct(array $config = [])
{
    //
    $getCookie=\Yii::$app->request->cookies;
    //得到购物车里的数据
    if($getCookie->has("cart")){
        $cart=$getCookie->getValue("cart");
    }else{
        $cart=[];
    }

    //属性赋值
    $this->_cart=$cart;

    parent::__construct($config);
}
public function add($goodsId,$num)
{
    if (key_exists($goodsId, $this->_cart)) {
        //如果有则追加
        $this->_cart[$goodsId] += $num;
    } else {
        //不存在
        $this->_cart[$goodsId] = $num;

    }
    return $this;
}
//删
    public function del($goodsId){
    if(isset($this->_cart[$goodsId])){
        unset($this->_cart[$goodsId]);
    }
    return $this;
    }
//改
public function update($goodsId,$num){
        //修改直接把原来的覆盖
      $this->_cart[$goodsId]=$num;
    return $this;

}
//查
public function get(){

    return $this->_cart;

}
//清空数据
public function flush(){
    $this->_cart=[];
    return $this;
}
//保存数据
public function save(){

    //操作cookie数据
    $setCookie=\Yii::$app->response->cookies;
    //生成cookie对象
$cartCookie=new Cookie([
    'name'=>'cart',
    'value'=>$this->_cart,
    'expire'=>time()+ $this->expireTime
]);
    //把数据添加到cookie中
    $setCookie->add($cartCookie);

}

//用户登录后同步到数据库
    public function synDb()
    {
   //得到cookie中购物车的数据
        //检测cookie中购物车的数据在数据库中是否存在 存在修改
        foreach ($this->_cart as $goodsId=>$num){
        //检测在数据库中是否存在
            $memberId=\Yii::$app->user->id;
            $cart=\frontend\models\Cart::find()->where(['goods_id'=>$goodsId,'member_id'=>$memberId])->one();
            if($cart === null){
              $cart=new \frontend\models\Cart();
              $cart->member_id=$memberId;
              $cart->goods_id=$goodsId;
              $cart->num=$num;

            }
            else{
              $cart->num += $num;

            }
            $cart->save();
        }
       return $this ;
   }
}
