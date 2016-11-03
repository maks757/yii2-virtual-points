# yii2 virtual point

#### Install
```
composer.phar require maks757/yii2-virtual-point
```
or
```
composer require maks757/yii2-virtual-point
```
and applying migrations
```
php yii migrate --migrationPath=@vendor/maks757/yii2-virtual-point/migrations
```
or
```
yii migrate --migrationPath=@vendor/maks757/yii2-virtual-point/migrations
```

#### Configuration

##### main.php (config)
```php
'components' => [
    // Point config
    'points' => [
        'class' => \bl\virtual_points\Points::className(),
        
        //Set key
        'category' => 'auth' or User::className(),
        //or
        //'ar_object' => new User(),
    ],
    // ...
]
```
#### Using 
```php
   //add point to user
   $user = User::find()->one();
   /** @var $point Points */
   $size_point = User::POINT_ADD_WINNER // or integer
   $point = Yii::$app->points;
   $point->ar_object = $user;
   $point->addPoint($size_point);
   //
```
#### Using example
```php
    //get points
    /** @var $point Points */
    $point = Yii::$app->points;
    $points = $point->getAllPoint();
    //or
    //$points = $point->getPoint($object_id);
    //
```
![Alt text](/image/author.jpg "Optional title")
