<?php
 $form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username');
echo  $form->field($admin,'password')->passwordInput();
echo $form->field($admin,'tel');
echo $form->field($admin,'email');
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();