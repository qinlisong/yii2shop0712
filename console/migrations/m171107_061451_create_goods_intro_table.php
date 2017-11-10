<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m171107_061451_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer(20)->notNull()->comment("商品id"),
            'content'=>$this->text()->notNull()->comment("详情"),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
