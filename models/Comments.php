<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property integer $idnews
 * @property string $text
 * @property string $user
 * @property string $date
 *
 * @property News $idnews0
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idnews', 'text', 'user', 'date'], 'required'],
            [['idnews'], 'integer'],
            [['text'], 'string'],
            [['date'], 'safe'],
            [['user'], 'string', 'max' => 128],
            [['idnews'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['idnews' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idnews' => 'Idnews',
            'text' => 'Text',
            'user' => 'User',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdnews0()
    {
        return $this->hasOne(News::className(), ['id' => 'idnews']);
    }
}
