<?php echo \yii\bootstrap\Html::a("添加分类",['add'],['class'=>'btn btn-info'])?>
<table class="table">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>简介</td>
        <td>状态</td>
        <td>排序</td>
        <td>类型</td>
        <td>操作</td>
    </tr>
    <?php foreach ($cates as $cate):?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->name?></td>
            <td><?=$cate->intro?></td>
            <td><?=$cate->status?></td>
            <td><?=$cate->sort?></td>
            <td><?=$cate->type?></td>
            <td><?php
                echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$cate->id],['class'=>'btn btn-info']) ;
                echo \yii\bootstrap\Html::a("删除",['del','id'=>$cate->id],['class'=>'btn btn-danger'])  ;

                ?>

            </td>






        </tr>

    <?php endforeach;?>
</table>