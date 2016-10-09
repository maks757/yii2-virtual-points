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
     * @param int $point
     * @param string|null $description
     */
    public function addPoint($point, $description = null)
    {
        $class_name = sha1($this->getObjectClassName());
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

    private function getObjectClassName()
    {
        /** @var $object ActiveRecord */
        $object = $this->owner->ar_object;
        if(!empty($object)){
            return $object::className();
        } else
            throw new InvalidValueException('Pleas set value to "ar_object" param.');
    }
}