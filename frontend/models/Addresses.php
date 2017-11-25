<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "addresses".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $contry
 * @property string $address
 * @property string $tel
 * @property integer $status
 */
class Addresses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addresses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'status'], 'integer'],
            [['name', 'province', 'city', 'contry'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 50],
            [['tel'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '用户id',
            'name' => '收货人姓名',
            'province' => '省',
            'city' => '市',
            'county' => '区县',
            'address' => '收货地址',
            'tel' => '电话',
            'status' => '状态',
        ];
    }
}
