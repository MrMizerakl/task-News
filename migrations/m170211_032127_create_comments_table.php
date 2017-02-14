<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 * Has foreign keys to the tables:
 *
 * - `news`
 */
class m170211_032127_create_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'idnews' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'user' => $this->string(128)->notNull(),
            'date' => $this->date()->notNull(),
        ]);

        // creates index for column `idnews`
        $this->createIndex(
            'idx-comments-idnews',
            'comments',
            'idnews'
        );

        // add foreign key for table `news`
        $this->addForeignKey(
            'fk-comemnts-idnews',
            'comments',
            'idnews',
            'news',
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
            'fk-comments-idnews',
            'comments'
        );

        // drops index for column `idnews`
        $this->dropIndex(
            'idx-comments-idnews',
            'comments'
        );

        $this->dropTable('comments');
    }
}
