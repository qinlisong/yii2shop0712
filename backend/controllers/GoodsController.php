<?php

namespace backend\controllers;

use backend\models\Brand;
use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //搜索功能
        //构造查询对象
        //构造查询对象
        $query = Goods::find();
        // var_dump($request->get());exit;
        //接收变量;
        $request=\Yii::$app->request;
        $keyword=$request->get('keyword');
        $minPrice=$request->get('minprice');
        $maxPrice=$request->get('maxprice');
//        var_dump($keyword,$minPrice,$maxPrice);exit;
//        $status=$request->get('status');
        if ($minPrice>0){
            //拼接条件
            $query->andWhere("shop_price >= {$minPrice}");
        }
        if ($maxPrice>0){
            $query->andWhere("shop_price <= {$maxPrice}");
        }
        if (isset($keyword)){
            $query->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }
        //判断0和1的情况必需用三等号
//        if ($status ==="1" or $status==="0"){
//            $query->andWhere("status= {$status}");
//        }

//      var_dump($goods);die();
        //分页
        //1.总条数
        //2.一页显示几条数据
        //3.当前页
        //查出总条数
        $count=Goods::find()->count();
        //var_dump($count);exit;

        //每页显示几条数据
        $pageSize=4;
        //创建分页对象
        $page=new Pagination(
            [
                'pageSize'=>$pageSize,
                'totalCount'=>$count
            ]);
        //接收所有数据
        $goods=$query->limit($page->limit)->offset($page->offset)->all();

        return $this->render('index',['goods'=>$goods,'page'=>$page]);
    }

    public function actionAdd()
    {
        $intro=new GoodsIntro();
        $goods=new Goods();
        //分类的回显因为和增加用一个视图要回显功能
        $cates=GoodsCategory::find()->all();
        $options=ArrayHelper::map($cates,"id","name");
        //品牌分类
        $brand=Brand::find()->all();
        $brands=ArrayHelper::map($brand,"id","name");
        $goods->status=1;
         $goods->is_on_sale=1;
        //接收表单请求
        $request=\Yii::$app->request;
        //判断是不是post提交
        if($request->isPost){
//            绑定数据
            if($goods->load($request->post())){
                //验证
                if($goods->validate()){
                    //判断某一天到底有没有货品
                    $goodsCount=GoodsDayCount::findOne(['day' =>date("Ymd",time())]);
                    //如果是同一天添加商品就执行下面的goods_day_count
                    if (empty($goodsCount)) {
                        $goodsCount=new GoodsDayCount();
//                  var_dump( $goodsCount);exit;
                        $goodsCount->day=date("Ymd",time());
                      //写死增加一个
                        $goodsCount->count= 1;
//                var_dump( $goodsCount->count);exit;
                        $goodsCount->save();
                    }else{
//                    取出数据加一
                        $count = $goodsCount->count;
                        $goodsCount->count = $count+1;
                        $goodsCount->save();
                    }
                    $goods->inputtime=time();
//                拼接货号
                    $goods->sn=date("Ymd",time()).(substr('00000'. $goodsCount->count,-5));
//                    $goods->save();
                    $goods->save();
                    $id=$goods->id;
                    $aa=$request->post()['Goods']['path'];
                    foreach ($aa as $v){
                    $gallery=new GoodsGallery();
                    $gallery->goods_id=$id;
                    $gallery->path=$v;
                    $gallery->save();
                    }
                  //富文本上传
//                   $intro=new GoodsIntro();
                //    var_dump($request->post()['Goods']['content']);exit;
                //    $intro->load($request->post());
                   // var_dump($intro);exit;
                    $intro->goods_id=$goods->id;
                    $intro->content=$request->post()['Goods']['content'];
                    $intro->save();
    //跳转
                    return $this->redirect(['index']);
                }
                }
            }
     return $this->render("add",['goods'=>$goods,'options'=>$options,'brands'=>$brands,'intro'=>$intro]);
}


//编辑
    public function actionEdit($id)
    {     $goods=Goods::findOne($id);
//        var_dump($goods);exit;
    //详情回显
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
       $goods->content=$intro->content;
//        var_dump($intro);exit;
    //视图回显的分类
        $cates=GoodsCategory::find()->all();
        $options=ArrayHelper::map($cates,'id','name');
        //循环多图出来回显
        $gallerys=GoodsGallery::find()->where(['goods_id'=>$id])->all();
         foreach ($gallerys as $gallery){
             //goods定义path属性定义一个空字符串来接收多图数据库的图片
             $goods->path[]=$gallery['path'];
//             var_dump($gallery);exit;
         }
        //视图回显的品牌
            $brands=Brand::find()->all();
            $brands=ArrayHelper::map($brands,'id','name');
            //设置的默认
            $goods->status=1;
            $goods->is_on_sale=1;
            //回显详情

           //接收表单请求
            $request=\Yii::$app->request;
        //判断是不是post提交
            if($request->isPost){
//            var_dump($request->post());exit;
//            绑定数据
            if($goods->load($request->post())){

                //验证
                if($goods->validate()){
//                    echo 1;die();
                    $goods->inputtime=time();
                    $goods->save();
                    //跳转
                }
                //回显成功后把数据库以前的图片删除
                $gallers=GoodsGallery::findAll(['goods_id'=>$id]);
                foreach ($gallers as $gallery){
//                    var_dump($gallery);exit;
                    $gallery->delete();
                }
                //多图片上传
                $aa=$request->post()['Goods']['path'];
//                var_dump($aa);exit;
                foreach ($aa as $v){
                    $gallery=new GoodsGallery();
                    $gallery->goods_id=$id;
                    $gallery->path=$v;
                    $gallery->save();
                }
            }
            return $this->redirect(['goods/index']);

        }
        return $this->render("add",['goods'=>$goods,'options'=>$options,'brands'=>$brands,'intro'=>$intro]);
    }
//删除

    public function actionDel($id)
    {
        $goods=Goods::findOne($id);
        $gallerys=GoodsGallery::findAll(['goods_id'=>$id]);
           foreach ($gallerys as $v){
               $v->delete();
           }
        GoodsIntro::findOne(['goods_id'=>$id])->delete();
//        $gallery=GoodsGallery::findOne($id)
        $goods->delete();
        return $this->redirect("index");
}

    public function actionUpload()
    {
        //var_dump($_FILES["file"]['tmp_name'] );exit;

//七牛云上传

        $config = [
            'accessKey'=>'CvxOijzY8tJxhSYO3e4EDdrnkE4EY2I6F6jtKjxV',//ak
            'secretKey'=>'GoDoEo6_3JoHgpzniGD5zWe7EaT-LeD7Za3OKkN8',//sk
            'domain'=>'http://oyvhcwjto.bkt.clouddn.com/',//域名
            'bucket'=>'php0712',//空间名称
            'area'=>Qiniu::AREA_HUANAN//区域
        ];

        //实例化对象
        $qiniu = new Qiniu($config);
        $key = uniqid();
        $key=microtime();
//调用上传方式
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
        $url = $qiniu->getLink($key);
//exit($url);
        $info=[
            'code'=>0,
            'url'=>$url,
            'attachment'=>$url
        ];

        exit(Json::encode($info));
    }


    //商品详情
    public function actionLook($id)
    {   $goods=Goods::findOne($id);
        $gallerys=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        $intro=GoodsIntro::findOne(['goods_id'=>$id]);
//       $intros=json_encode($intro);
//       var_dump($intro);exit;

return $this->render("look",['gallerys'=>$gallerys , 'intro'=>$intro ,'goods'=>$goods]);
}
}
