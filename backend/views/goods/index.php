
<?php
use \yii\widgets\LinkPager;
?>

<div class="row">
    <div class="col-md-2 "><?=\yii\bootstrap\Html::a("添加商品",['add'],['class'=>'btn btn-info'])?>
    </div>
    <div class="col-md-10">
        <form class="form-inline pull-right">
            <div class="form-group">
                <label for="exampleInputName2"></label>
                <input type="text" class="form-control" id="exampleInputName2" name="minprice"  placeholder="最低价">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail2"></label>
                <input type="text" class="form-control" id="exampleInputEmail2"  name="maxprice" placeholder="最高价">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail2"></label>
                <input type="text" class="form-control"  name="keyword" id="exampleInputEmail2" placeholder="请输入商品或者货号">
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>


    </div>

</div>










<table class="table">
    <tr>
        <td>商品id</td>
        <td>商品名字</td>
        <td>商品编号</td>
        <td>商品图片</td>
        <td>分类id</td>
        <td>品牌id</td>
        <td>市场价格</td>
        <td>商品价格</td>
        <td>库存</td>
        <td>是否上架</td>
        <td>状态</td>
        <td>排序</td>
        <td>加入时间</td>
        <td>操作</td>
    </tr>
<?php
foreach ($goods as $good):?>
    <tr>
        <td><?=$good->id?></td>
        <td><?=$good->name?></td>
        <td><?=$good->sn?></td>
        <td><?=\yii\bootstrap\Html::img($good->image,['height'=>30])?></td>
        <td><?=$good->cate['name']?></td>
        <td><?=$good->brand['name']?></td>
        <td><?=$good->market_price?></td>
        <td><?=$good->shop_price?></td>
        <td><?=$good->stock?></td>
        <td><?=$good->is_on_sale?></td>
        <td><?=$good->status?></td>
        <td><?=$good->sort?></td>
        <td><?=date('Y:m:d H:m:s',$good->inputtime)?></td>
    <td>
    <?php
    echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$good->id],['class'=>'btn btn-warning']);

      echo \yii\bootstrap\Html::a("删除",['del','id'=>$good->id],['class'=>'btn btn-danger']);
   echo \yii\bootstrap\Html::a("详情",['look','id'=>$good->id],['class'=>'btn btn-info']);
    ?>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<?php
//接收分页的数据

//var_dump($page);die();
echo LinkPager::widget([
    'pagination' => $page
]);

?>