<h1 align="center">品牌列表</h1>
<table class="table">
    <?PHP echo \yii\bootstrap\Html::a("添加数据",['add'],['class'=>'btn btn-success'])?>
    <tr>
        <td>id</td>
        <td>姓名</td>
        <td>介绍</td>
        <td>logo</td>
        <td>排序</td>
        <td>状态</td>
        <td>操作</td>
</tr>
<?php foreach($brands as $brand):?>
    <tr>
        <td><?=$brand->id?></td>
        <td><?=$brand->name?></td>
        <td><?=$brand->intro?></td>
        <td>
            <?=\yii\bootstrap\Html::img([$brand->logo],['height'=>30])?>
        </td>
        <td><?=$brand->sort?></td>
       <td><?=$brand->status?></td>


        <td>
            <?php
            echo \yii\bootstrap\Html::a("编辑",['brand/edit','id'=>$brand->id],["class"=>"btn btn-warning"]);
            echo \yii\bootstrap\Html::a("删除",['brand/hy','id'=>$brand->id],["class"=>"btn btn-danger"]);


            ?>
        </td>
    </tr>
<?php endforeach;?>
       </table>

<?php
//接收页面
echo \yii\widgets\LinkPager::widget(['pagination' => $page]);

?>





