<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ecategory`.
 */
class m170211_020952_create_ecategory_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('ecategory', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('ecategory');
    }
}
