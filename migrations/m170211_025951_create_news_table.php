<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m170211_025951_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'data' => $this->date()->notNull(),
            'category' => $this->integer()->notNull(),
            'photo' => $this->string(),
        ]);

        // creates index for column `category`
        $this->createIndex(
            'idx-news-category',
            'news',
            'category'
        );

        // add foreign key for table `ecategory`
        $this->addForeignKey(
            'fk-news-category',
            'news',
            'category',
            'ecategory',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `ecategory`
        $this->dropForeignKey(
            'fk-news-category',
            'news'
        );

        // drops index for column `category`
        $this->dropIndex(
            'idx-news-category',
            'news'
        );

        $this->dropTable('news');
    }
}



















