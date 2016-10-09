<?php

namespace bl\virtual_points\entities;

use Yii;

/**
 * This is the model class for table "list_object_points".
 *
 * @property integer $id
 * @property integer $key_id
 * @property integer $object_id
 * @property integer $point
 *
 * @property KeyObjectPoints $key
 */
class ListObjectPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'list_object_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key_id', 'object_id', 'point'], 'integer'],
            [['key_id'], 'exist', 'skipOnError' => true, 'targetClass' => KeyObjectPoints::className(), 'targetAttribute' => ['key_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_id' => 'Key ID',
            'object_id' => 'Object ID',
            'point' => 'Point',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKey()
    {
        return $this->hasOne(KeyObjectPoints::className(), ['id' => 'key_id']);
    }
}
