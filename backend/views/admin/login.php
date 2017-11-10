<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
/* @var $form ActiveForm */
?>
<div class="admin-login">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($modle, 'username') ?>
        <?= $form->field($modle, 'password')->passwordInput() ?>
    <?= $form->field($modle, 'rememberMe')->checkbox() ?>


    <div class="form-group">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-login -->
