<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%declaration}}`.
 */
class m191114_174519_create_declaration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%declaration}}', [
            'id' => $this->primaryKey(),
            'title' => $this-> string() -> notNull(),
            'description' => $this-> string(),
            'date' => $this-> dateTime(),
            'city' => $this -> string(),
            'total' => $this -> integer() -> defaultValue(0),
            'category' => $this -> string(),
            'status' => $this-> string(),

            'viewed' => $this -> integer() -> defaultValue(0),
            'user_id' => $this -> integer(),
        ]);
        $this -> createIndex(
            'idx-declaration-user_id',
            'declaration',
            'user_id'
        );
        $this-> addForeignKey(
            'fk-declaration-user_id',
            'declaration',
            'user_id',
            'user',
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
            'idx-declaration-user_id',
            'declaration'
        );
        $this->dropForeignKey(
            'fk-declaration-user_id',
            'declaration'
        );
        $this->dropTable('{{%declaration}}');
    }
}
