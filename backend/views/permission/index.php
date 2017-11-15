<?=\yii\bootstrap\Html::a("添加权限",['add','class'=>'btn btn-success'])?>
<table class="table">
    <tr>
        <td>名称</td>
        <td>详情描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($permissions as $permission):?>
    <tr>
     <td><?=  strpos($permission->name,"/")?"---":"";?>
         <?=$permission->name?></td>
        <td><?=$permission->description?></td>
        <td>
        <?php
        echo \yii\bootstrap\Html::a("编辑",['edit','name'=>$permission->name]);
        echo \yii\bootstrap\Html::a("删除",['del','name'=>$permission->name]);
        ?>
        </td>
    </tr>
    <?php endforeach;?>
</table>

