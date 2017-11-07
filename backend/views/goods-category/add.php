<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($modle,"name");
echo $form->field($modle,"parent_id")->hiddenInput();
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
            callback: {
                onClick: function(event, treeId, treeNode){
                $("#goodscategory-parent_id").val(treeNode.id);
                },
            },
			data: {
				simpleData: {
					enable: true,
					idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
				}
			}
		}',
    'nodes' => $cates,
]);
//var_dump($cates);die();
echo $form->field($modle,"intro")->textarea();
echo \yii\bootstrap\Html::submitButton("提交",['class'=>'btn btn-success']);

\yii\bootstrap\ActiveForm::end();