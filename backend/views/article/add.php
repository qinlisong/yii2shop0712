
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($articles,"name");
echo $form->field($articles,"article_categry_id");
echo $form->field($articles,"intro")->textInput();
echo $form->field($articles,"sort");
echo $form->field($articles,"status")->inline()->radioList(['-1'=>'删除','0'=>'隐藏','1'=>'显示']);
//echo $form->field($articles,"inputtime");
echo $form->field($articles,"content")->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();