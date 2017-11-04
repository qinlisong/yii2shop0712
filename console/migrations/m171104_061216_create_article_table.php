<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171104_061216_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(30)->notNull()->comment("文章名字"),
            'article_categry_id'=>$this->integer(2)->notNull()->comment("分类id"),
            'intro'=>$this->text()->notNull()->comment("简介"),
            'status'=>$this->integer(2)->notNull()->comment('状态'),
            'sort'=>$this->integer(2)->notNull()->comment("排序"),
            'inputtime'=>$this->string(50)->notNull()->comment("录入时间"),
            'content'=>$this->text()->notNull()->comment("内容")
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
