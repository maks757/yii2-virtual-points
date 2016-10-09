<?php

namespace bl\virtual_points\entities;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "list_object_points".
 *
 * @property integer $id
 * @property integer $key_id
 * @property integer $object_id
 * @property integer $point
 * @property string $description
 * @property integer $date_create
 * @property integer $date_update
 *
 * @property KeyObjectPoints $key
 */
class ListObjectPoints extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'date_create',
                'updatedAtAttribute' => 'date_update',
            ]
        ];
    }

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
            [['key_id', 'object_id', 'point', 'date_create', 'date_update'], 'integer'],
            [['description'], 'string', 'max' => 255],
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
