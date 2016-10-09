<?php

use yii\db\Migration;

class m160916_135740_create_table extends Migration
{
    public function up()
    {
        $this->createTable('key_object_points', [
            'id' => $this->primaryKey(),
            'key' => $this->string(64),
        ]);

        $this->createTable('list_object_points', [
            'id' => $this->primaryKey(),
            'key_id' => $this->integer(11),
            'object_id' => $this->integer(11),
            'point' => $this->integer(11),
            'description' => $this->string(255),
            'date_create' => $this->integer(11),
            'date_update' => $this->integer(11),
        ]);

        $this->addForeignKey('list_object_points_key_object_points_fk',
            'list_object_points', 'key_id',
            'key_object_points', 'id',
            'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m160916_135740_create_table cannot be reverted.\n";

        $this->dropForeignKey('list_object_points_key_object_points_fk', 'list_object_points');

        $this->dropTable('key_object_points');
        $this->dropTable('list_object_points');

        return true;
    }
}
