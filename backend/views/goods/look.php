<?php
echo \yii\bootstrap\Html::a("返回首页",['goods/index'],['class'=>'btn btn-info']);
?>
<table class="table">
    <tr>
        <th style="text-align: center">商品名称</th>
        <th style="text-align: center">市场价格</th>
        <th style="text-align: center">本店价格</th>
        <th style="text-align: center">图片</th>
        <th style="text-align: center">缩略图</th>
        <th style="text-align: center">库存</th>
        <th style="text-align: center">详情</th>
        <th style="text-align: center">操作</th>
    </tr>
    <tr>

        <td><?=$goods->name?></td>
        <td><?=$goods->market_price?></td>
        <td><?=$goods->shop_price?></td>
        <td><?=\yii\bootstrap\Html::img($goods->image,['width'=>'30','height'=>'30','class'=>'img-circle'])?></td>
        <td>
            <?php
            foreach ($gallerys as $gallery){
                echo \yii\bootstrap\Html::img($gallery->path,['width'=>'30','height'=>'30','class'=>'img-circle']);
            }
            ?>
        </td>
        <td><?=$goods->stock?></td>
        <td><?=$intro['content']?></td>

    </tr>



</table>