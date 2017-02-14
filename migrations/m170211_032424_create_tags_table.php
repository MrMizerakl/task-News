<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 * Has foreign keys to the tables:
 *
 * - `news`
 * - `etags`
 */
class m170211_032424_create_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tags', [
            'id' => $this->primaryKey(),
            'idnews' => $this->integer()->notNull(),
            'idtag' => $this->integer(),
        ]);

        // creates index for column `idnews`
        $this->createIndex(
            'idx-tags-idnews',
            'tags',
            'idnews'
        );

        // add foreign key for table `news`
        $this->addForeignKey(
            'fk-tags-idnews',
            'tags',
            'idnews',
            'news',
            'id',
            'CASCADE'
        );

        // creates index for column `idtag`
        $this->createIndex(
            'idx-tags-idtag',
            'tags',
            'idtag'
        );

        // add foreign key for table `etags`
        $this->addForeignKey(
            'fk-tags-idtag',
            'tags',
            'idtag',
            'etags',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `news`
        $this->dropForeignKey(
            'fk-tags-idnews',
            'tags'
        );

        // drops index for column `idnews`
        $this->dropIndex(
            'idx-tags-idnews',
            'tags'
        );

        // drops foreign key for table `etags`
        $this->dropForeignKey(
            'fk-tags-idtag',
            'tags'
        );

        // drops index for column `idtag`
        $this->dropIndex(
            'idx-tags-idtag',
            'tags'
        );

        $this->dropTable('tags');
    }
}
