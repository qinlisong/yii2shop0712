<?php
 $form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username');
echo  $form->field($admin,'password_hash')->passwordInput();
//echo $form->field($admin,'email');
//echo  $form->field($admin,'salt')->passwordInput();
//echo $form->field($admin,'auth_key')->passwordInput();
//echo $form->field($admin,'last_login_ip');
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();