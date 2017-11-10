<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m171105_061210_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull()->comment("树"),
            'lft' => $this->integer()->notNull()->comment("左值"),
            'rgt' => $this->integer()->notNull()->comment("右值"),
            'depth' => $this->integer()->notNull()->comment(("第几层")),
            'name' => $this->string()->notNull()->comment("分类名称"),
            'intro'=>$this->text()->notNull()->comment("产品介绍"),
            'parent_id'=>$this->integer()->notNull()->defaultValue(0)->comment("父id"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
