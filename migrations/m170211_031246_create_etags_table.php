<?php

use yii\db\Migration;

/**
 * Handles the creation of table `etags`.
 */
class m170211_031246_create_etags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('etags', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('etags');
    }
}
