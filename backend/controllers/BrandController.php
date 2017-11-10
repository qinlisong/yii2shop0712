<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\qiniu\Qiniu;
class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /*分页
        1.总条数
        2.每页显示几条
        3.当前页数
         *
         *
         */

        //总条数
        $count=Brand::find()->count();
        //每页显示几条
        $pagesize=2;
        //创建分页对象
        $page=new Pagination(['pagesize'=>$pagesize,'totalCount'=>$count]);
        //处理数据

        $brands = Brand::find()->limit( $page->limit)->offset($page->offset)->all();
        //显示给视图
        return $this->render('index', ['brands' => $brands,'page'=>$page]);
    }

    public function actionAdd()
    {
        //创建一个接收的模型
        $brand=new Brand();
//       var_dump($brand->getErrors());exit;
       $brand-> status=1;
       //判断是否是post提交
        $request=new Request();
//        绑定数据
       if($brand->load($request->post())){
//      //图片上传
//           $brand->imgFile=UploadedFile::getInstance($brand,"imgFile");
//         //拼路径
//           $filePath="images/".time().".".$brand->imgFile->extension;
////           var_dump($filePath);exit;
//           //保存路径
//           $brand->imgFile->saveAs($filePath,false);
//           var_dump($brand->imgFile->saveAs($filePath,false));exit;
           //验证
           if($brand->validate()){
//               echo 11;exit;
               //绑定图片到数据库
//               $brand->logo=$filePath;
               $brand->save();
               //跳转

               return $this->redirect(['index']);
           }else{
               $brand->getErrors();
           }

       }else{
           $brand->getErrors();
       }
        //跳转
        return $this->render("add", ['brand' => $brand]);
    }

    public function actionEdit($id)
    {
        //创建一个接收的模型
//        $brand=new Brand();
        $brand=Brand::findOne($id);
        $brand-> status=1;

        //判断是否是post提交
        $request=new Request();
//        绑定数据
        if($brand->load($request->post())){
//            var_dump($brand);exit;
//            //图片上传
//            $brand->imgFile=UploadedFile::getInstance($brand,"imgFile");
//            //拼路径
//            $filePath="images/".time().".".$brand->imgFile->extension;
////           var_dump($filePath);exit;
//            //保存路径
//            $brand->imgFile->saveAs($filePath,false);
////           var_dump($brand->imgFile->saveAs($filePath,false));exit;
            //验证
            if($brand->validate()){
//               echo 11;exit;
                //保存图片
//                $brand->logo=$filePath;
                $brand->save();
                //跳转
                return $this->redirect(['brand/index']);
            }else{
                $brand->getErrors();
            }

        }else{
            $brand->getErrors();
        }
        //跳转
        return $this->render("add", ['brand' => $brand]);


    }

    public function actionDel($id)
    {
      //得到要修改的数据
        $brand=Brand::findOne($id);
        $brand->delete();
        //跳转
        return $this->redirect(['brand/index']);
    }

    public function actionHy($id)
    {
        $brand = Brand::findOne($id);
        if ($brand->status == -1) {
            $brand->save(false);
            echo \Yii::$app->session->setFlash("删除不成功");

            return $this->redirect(['brand/index']);
        } else {
            $brand->delete();
        }
        return $this->redirect(['brand/index']);

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
$key = time();
//调用上传方式
$qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
$url = $qiniu->getLink($key);
//exit($url);
  $info=[
      'code'=>0,
      'url'=>$url,
      'attachment'=>$url
  ];

  exit(Json::encode($info));//这一步出错
    }
}