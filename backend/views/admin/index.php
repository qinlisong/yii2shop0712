<h1 align="center">管理员列表</h1>
<?php echo  \yii\bootstrap\Html::a("添加管理员",['add'],['class'=>'btn btn-info'])?>
<?php echo  \yii\bootstrap\Html::a("退出",['login'],['class'=>'btn btn-warning','style'=>'float:right'])?>
<table class="table" style="text-align: center">

    <tr>
        <th>id</th>
        <th>登录名</th>
<!--        <th>邮箱</th>-->
<!--        <th>盐</th>-->
        <th>自动登录令牌</th>
        <th>令牌创造时间</th>
        <th>注册时间</th>
        <th>最后登录时间</th>
       <th>最后登录的ip</th>
        <th>操作</th>
    </tr>

    <?php foreach ($admins as $admin):  ?>
    <tr>
        <td><?=$admin->id?></td>
        <td><?=$admin->username?></td>
        <td><?=$admin->auth_key?></td>
        <td><?=date('Y:m:d H:m:s',$admin->token_create_time)?></td>
        <td><?=date('Y:m:d H:m;s',$admin->add_time)?></td>
        <td><?=date('Y:m:d H:m:s',$admin->last_login_time)?></td>
        <td><?=date($admin->last_login_ip)?></td>
        <td>
            <?php
       echo \yii\bootstrap\Html::a("编辑",['edit','id'=>$admin->id],['class'=>'btn btn-success']) ;
     echo \yii\bootstrap\Html::a("删除",['del','id'=>$admin->id],['class'=>'btn btn-danger']) ;
            ?>
        </td>
    <tr>
    <?php endforeach;?>
    <tr>
</table>