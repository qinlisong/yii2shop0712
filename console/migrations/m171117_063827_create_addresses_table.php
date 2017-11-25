<?php

use yii\db\Migration;

/**
 * Handles the creation of table `addresses`.
 */
class m171117_063827_create_addresses_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('addresses', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment("用户id"),
            'name'=>$this->string(20)->comment("收货人姓名"),
            'province'=>$this->string(20)->comment("省"),
            'city'=>$this->string(20)->comment("市"),
            'contry'=>$this->string(20)->comment("区县"),
            'address'=>$this->string(50)->comment("收货地址"),
            'tel'=>$this->string(30)->comment("电话"),
            'status'=>$this->smallInteger(1)->defaultValue(0)->comment("状态:1 默认 0 非默认")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('addresses');
    }
}
