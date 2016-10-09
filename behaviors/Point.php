<?php
/**
 * @author Maxim Cherednyk <maks757q@gmail.com, +380639960375>
 */

namespace bl\virtual_points\behaviors;


use bl\imagable\BaseImagable;
use Yii;
use yii\base\Behavior;
use yii\helpers\BaseFileHelper;

class Point extends Behavior
{
    private $object_key;

    public function init()
    {
        if(!empty($this->owner->pk)){
            $this->object_key = $this->owner->ar_object->$this->owner->pk;
        }
        var_dump($this->object_key);
    }

    public static function addPoint($point)
    {
    }
}