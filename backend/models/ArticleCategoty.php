<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_categoty".
 *
 * @property integer $id
 * @property string $name
 * @property string $intro
 * @property integer $status
 * @property string $sort
 * @property string $type
 */
class ArticleCategoty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_categoty';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'intro', 'status', 'sort', 'type'], 'required'],
            [['intro'], 'string'],
            [['status'], 'integer'],
            [['name', 'sort', 'type'], 'string', 'max' => 30],
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
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'type' => '类型',
        ];
    }


}
