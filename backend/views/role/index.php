<h1>角色列表</h1>
<?=\yii\bootstrap\Html::a("添加角色",['add','class'=>'btn btn-success'])?>
<table class="table">
    <tr>
        <td>角色名称</td>
        <td>角色描述</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    <?php foreach ($roles as $role):?>
    <tr>
         <td><?=$role->name?></td>
        <td><?=$role->description?></td>
        <td><?php
           $auth=Yii::$app->authManager;
           //得到当前角色的所有权限
            $pers=$auth->getPermissionsByRole($role->name);
//            var_dump($pers);exit;
            //把权限循环出来
            foreach ($pers as $per){
                echo $per->description ."||";
            }
            ?></td>
        <td>
        <?php
        echo \yii\bootstrap\Html::a("编辑",['edit','name'=>$role->name]);
        echo \yii\bootstrap\Html::a("删除",['del','name'=>$role->name]);
        ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

