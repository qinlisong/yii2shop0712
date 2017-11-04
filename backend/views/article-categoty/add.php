
<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($cates,"name");
//echo $form->field($cates,"article_categry_id");
echo $form->field($cates,"intro")->textInput();
echo $form->field($cates,"sort");
echo $form->field($cates,"status")->inline()->radioList(['-1'=>'删除','0'=>'隐藏','1'=>'显示']);
//echo $form->field($cates,"inputtime");
echo $form->field($cates,"type")->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();