<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property string $logo
 * @property integer $sort
 * @property integer $status
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $imgFile;
    public static $statusText=['-1'=>'删除','0'=>'隐藏','1'=>'显示'];
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro',  'sort'], 'required'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['intro'], 'string', 'max' => 255],
            [['logo'],'safe'],
//           [['imgFile'],'file','extensions' => ['jpg','png','gif'],'skipOnEmpty' => false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'intro' => '介绍',
//            'logo' => '图片地址',
            'sort' => '排序',
            'status' => '状态',
            'imgFile'=>'图片'
        ];
    }

    public function getImage()
    {
        if(substr($this->logo,0,7)=="http://"){
          //  echo 1;exit;
         //   echo $this->logo;
            return $this->logo;
        }else{
            return "@web/".$this->logo;
        }

    }
}
