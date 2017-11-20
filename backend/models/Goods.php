<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $name
 * @property string $sn
 * @property string $logo
 * @property integer $goods_category_id
 * @property integer $brand_id
 * @property integer $market_price
 * @property integer $shop_price
 * @property integer $stock
 * @property integer $is_on_sale
 * @property integer $status
 * @property integer $sort
 * @property integer $inputtime
 */
class Goods extends \yii\db\ActiveRecord
{
    public $path;
    public static $statusText=['-1'=>'新品','0'=>'精品','1'=>'热销'];
    public static $is_on_saleText=['-1'=>'删除','0'=>'隐藏','1'=>'显示'];
    public $content;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',  'logo', 'goods_category_id', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status', 'sort'], 'required'],
            [[ 'goods_category_id', 'brand_id', 'market_price', 'shop_price', 'stock', 'is_on_sale', 'status', 'sort', ], 'integer'],
            [['name'], 'string', 'max' => 50],
//            [['sn'], 'string', 'max' => 15],
           // [['logo'], 'file','extensions' => ['jpg','png','gif'],'skipOnEmpty' => false],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '商品名称',
//            'sn' => '编号',
            'logo' => 'Logo',
            'goods_category_id' => '分类ID',
            'brand_id' => '品牌 ID',
            'market_price' => '市场价格',
            'shop_price' => '商品价格',
            'stock' => '库存',
            'is_on_sale' => '是否上架',
            'status' => '状态',
            'sort' => '排序',
//            'inputtime' => 'Inputtime',
        ];
    }

    public function getImage()
    {
        if(substr($this->logo,0,7) == "http://"){
            return $this->logo;
        }else{
            return"@web/".$this->logo;
        }
    }
    //得到分类
    public function getCate()
    {
        return $this->hasOne(GoodsCategory::className(),['id'=>'goods_category_id']);
    }


    public function getBrand()
    {
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);

    }
    public function getGallery()
    {
        return $this->hasMany(GoodsGallery::className(),['goods_id'=>'id']);

    }
    public function getIntro()
    {
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);

    }
}
