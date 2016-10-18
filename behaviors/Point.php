<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\virtual_points\behaviors;


use bl\imagable\BaseImagable;
use bl\virtual_points\entities\KeyObjectPoints;
use bl\virtual_points\entities\ListObjectPoints;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidValueException;
use yii\db\ActiveRecord;
use yii\helpers\BaseFileHelper;

class Point extends Behavior
{
    /**
     */
    public function getAllPoint()
    {
        $key = KeyObjectPoints::findOne(['key' => $this->getObjectClassKey()]);
        $user_point = ListObjectPoints::find()->select('object_id, sum(point) as points')
            ->where(['key_id' => $key->id])
            ->groupBy('object_id')
            ->asArray()->all();
        return $user_point;
    }

    /**
     * @param bool $showAll
     * @return mixed
     */
    public function getPoint($showAll = false)
    {
        $key = KeyObjectPoints::findOne(['key' => $this->getObjectClassKey()]);
        $user_point = ListObjectPoints::find()
            ->where(['key_id' => $key->id, 'object_id' => $this->getObjectKey()]);
        if($showAll){
            $user_point = $user_point->select('object_id, point, description, date_create')->all();
        } else {
            $user_point = $user_point->select('sum(point) as points')->asArray()->one();
        }
        return $showAll ? $user_point : $user_point['points'];
    }
    /**
     * @param int $point
     * @param string|null $description
     */
    public function addPoint($point, $description = null)
    {
        $this->setPoint($point, $description);
    }

    /**
     * @param int $point
     * @param string|null $description
     */
    public function takePoint($point, $description = null)
    {
        $this->setPoint($point, $description);
    }

    private function setPoint($point, $description = null)
    {
        $class_name = $this->getObjectClassKey();
        if(empty($key_point = KeyObjectPoints::findOne(['key' => $class_name]))) {
            $key_point = new KeyObjectPoints();
            $key_point->key = $class_name;
            $key_point->save();
        }

        $addPoint = new ListObjectPoints();
        $addPoint->key_id = $key_point->id;
        $addPoint->object_id = $this->getObjectKey();
        $addPoint->point = $point;
        $addPoint->description = $description;
        $addPoint->save();
    }

    private function getObjectKey(){
        if(!empty($this->owner->ar_object)){
            if(!empty(!empty($this->owner->pk))){
                $pk = $this->owner->pk;
                $object_key = $this->owner->ar_object->$pk;
            } else {
                /** @var $object ActiveRecord */
                $object = $this->owner->ar_object;
                $object_key = $object->getPrimaryKey();
            }
            return $object_key;
        } else
            throw new InvalidValueException('Pleas set value to "ar_object" param.');
    }

    private function getObjectClassKey()
    {
        /** @var $object ActiveRecord */
        $category_name = $this->owner->category;
        $object = $this->owner->ar_object;
        if(is_string($category_name)) {
            return sha1($category_name);
        } else {
            if (is_object($object)) {
                return sha1($object::className());
            } else {
                throw new InvalidValueException('Pleas set value to "ar_object" or "category" param.');
            }
        }
    }
}