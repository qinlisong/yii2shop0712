<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m171103_093045_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),

            'name'=>$this->string(30)->notNull()->comment("名称"),
            'intro'=>$this->string()->notNull()->comment("介绍"),
            'logo'=>$this->string(100)->notNull()->comment("图片地址"),
            'sort'=>$this->smallInteger()->notNull()->comment("排序"),
            'status'=>$this->smallInteger(1)->defaultValue(100)->defaultValue(1)->comment("状态"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
