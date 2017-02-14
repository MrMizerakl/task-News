<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "etags".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Tags[] $tags
 */
class Etags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['idtag' => 'id']);
    }

    public static function getListTags(){
        $data = static::find()->all();
        $value = (count($data)==0)? [''=>''] : ArrayHelper::map($data, 'id', 'name'); 

        return $value;
    }
}
