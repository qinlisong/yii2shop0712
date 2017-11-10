<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $goods backend\models\Goods */
/* @var $form ActiveForm */
?>
        <div class="goods-add">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($goods, 'name') ?>
         <?=$form->field($goods,"logo")->widget('manks\FileInput', [
             'clientOptions' => [
                 'pick' => [
                     'multiple' => false,
                 ],
                  'server' => \yii\helpers\Url::to('upload'),
                  'accept' => [
                  	'extensions' => 'png,jpg',
                  ],
             ],
         ]);?>
         <?=$form->field($goods,"path")->widget('manks\FileInput', [
             'clientOptions' => [
                 'pick' => [
                     'multiple' => true,
                 ],
                  'server' => \yii\helpers\Url::to('upload'),
                  'accept' => [
                  	'extensions' => 'png,jpg',
                  ],
             ],
         ]);?>
        <?= $form->field($goods, 'goods_category_id')->dropDownList($options) ?>
        <?= $form->field($goods, 'brand_id')->dropDownList($brands) ?>
        <?= $form->field($goods, 'market_price') ?>
        <?= $form->field($goods, 'shop_price') ?>
        <?= $form->field($goods, 'stock') ?>
        <?= $form->field($goods, 'is_on_sale')->radioList(['0'=>'下架','1'=>'上架']) ?>
        <?= $form->field($goods, 'status')->radioList(['-1'=>'新品','0'=>'精品','1'=>'热销']) ?>
        <?= $form->field($goods, 'sort') ?>
        <?= $form->field($goods,'content')->widget('kucha\ueditor\UEditor',[])?>
        <div class="form-group"><?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        </div><!-- goods-add -->
