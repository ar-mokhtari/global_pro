<?php

use yii\db\Migration;

/**
 * Handles adding location to table `user`.
 *
 * php yii migrate/create add_location_column_to_user_table --fields="location:text"
 */
class m180622_080827_add_location_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'location', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'location');
    }
}
