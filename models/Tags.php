<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property integer $idnews
 * @property integer $idtag
 *
 * @property Etags $idtag0
 * @property News $idnews0
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idnews'], 'required'],
            [['idnews', 'idtag'], 'integer'],
            [['idtag'], 'exist', 'skipOnError' => true, 'targetClass' => Etags::className(), 'targetAttribute' => ['idtag' => 'id']],
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
            'idtag' => 'Idtag',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtag0()
    {
        return $this->hasOne(Etags::className(), ['id' => 'idtag']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdnews0()
    {
        return $this->hasOne(News::className(), ['id' => 'idnews']);
    }
}
