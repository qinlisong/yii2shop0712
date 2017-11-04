<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/4
 * Time: 14:22
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article extends ActiveRecord
{
    //接收文章数
    public function rules(){
        return [
          [ ['name','article_categry_id','intro','status','sort','content'],'required'],
            [['article_categry_id','status','sort'],'integer']

        ];

    }

    public function attributeLabels()
    {
        return[
          'name'=>'名称',
          'article_categry_id'=>'分类id',
            'intro'=>'简介',
            'status'=>'状态',
            'sort'=>'排序',
//            'inputtime'=>'加入时间',
            'content'=>'内容'



        ];
    }
   // 一对一

    public function getCate()
    {
        return $this->hasOne(ArticleCategoty::className(), ['id'=>'article_categry_id']);
}




}