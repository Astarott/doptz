<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%photo}}`.
 */
class m191114_174559_create_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%photo}}', [
            'id' => $this->primaryKey(),
            'creationDate' => $this ->dateTime(),
            'path' => $this -> string(),

            'declaration_id' => $this -> integer() -> notNull(),
        ]);
        $this -> createIndex(
            'idx-declaration-photo_id',
            'photo',
            'declaration_id'
        );
        $this-> addForeignKey(
            'fk-declaration-photo_id',
            'photo',
            'declaration_id',
            'declaration',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-declaration-photo_id',
            'declaration'
        );
        $this->dropForeignKey(
            'fk-declaration-photo_id',
            'declaration'
        );

        $this->dropTable('{{%photo}}');
    }
}
