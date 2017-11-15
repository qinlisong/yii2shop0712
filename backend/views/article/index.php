<h1 align="center">文章列表</h1>
<table class="table">
    <?php
    echo \yii\bootstrap\Html::a("添加数据",['add'],['class'=>'btn btn-info']);
    ?>
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>分类id</td>
        <td>简介</td>
        <td>状态</td>
        <td>排序</td>
        <td>入库时间</td>
        <td>内容</td>
        <td>操作</td>
    </tr>
<?php foreach ($articles as $article):?>
    <tr>
        <td><?=$article->id?></td>
        <td><?=$article->name?></td>
        <td><?=$article->cate->name?></td>
        <td><?=$article->intro?></td>
        <td><?=$article->status?></td>
        <td><?=$article->sort?></td>
        <td><?=date('Y:m:d H:m:s',$article->inputtime)?></td>
        <td><?=$article->content?></td>
        <td><?php
         echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$article->id],['class'=>'btn btn-info']) ;
           echo \yii\bootstrap\Html::a("删除",['del','id'=>$article->id],['class'=>'btn btn-danger'])  ;


            ?>

        </td>






    </tr>

<?php endforeach;?>
</table>