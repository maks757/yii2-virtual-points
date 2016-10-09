<?php

namespace bl\virtual_points\entities;

use Yii;

/**
 * This is the model class for table "key_object_points".
 *
 * @property integer $id
 * @property string $key
 *
 * @property ListObjectPoints[] $listObjectPoints
 */
class KeyObjectPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'key_object_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListObjectPoints()
    {
        return $this->hasMany(ListObjectPoints::className(), ['key_id' => 'id']);
    }
}
