<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_categoty`.
 */
class m171104_035507_create_article_categoty_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_categoty', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->comment("名称"),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'status'=>$this->smallInteger(2)->notNull()->comment('状态'),
            'sort'=>$this->string(30)->notNull()->comment("排序"),
            'type'=>$this->string(30)->notNull()->comment('类型')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_categoty');
    }
}
