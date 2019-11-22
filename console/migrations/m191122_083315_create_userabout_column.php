<?php

use yii\db\Migration;

/**
 * Class m191122_083315_create_userabout_column
 */
class m191122_083315_create_userabout_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'user',
            'about',
            'string(255)'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn(
           'user',
           'about'
       );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191122_083315_create_userabout_column cannot be reverted.\n";

        return false;
    }
    */
}
