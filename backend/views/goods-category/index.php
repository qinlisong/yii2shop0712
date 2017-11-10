
<h1 align="center">分类列表</h1>>
<?php
use leandrogehlen\treegrid\TreeGrid;
?>
<?= TreeGrid::widget([
    'dataProvider' => $dataProvider,
    'keyColumnName' => 'id',
    'parentColumnName' => 'parent_id',
    'parentRootValue' => '0', //first parentId value
    'pluginOptions' => [
        'initialState' => 'collapsed',
    ],
    'columns' => [
        'id',
        'name',
        'parent_id',
        'intro',
//        ['class' => 'yii\grid\ActionColumn',]
        ['class' => 'backend\components\TreeColumn']
    ]
]); ?>
