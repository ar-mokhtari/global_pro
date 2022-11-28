<?php

use yii\db\Migration;

/**
 * Handles dropping country_division_city from table `user`.
 *
 * php yii migrate/create drop_country_division_city_column_from_user_table --fields="country:string(2):notNull,division:string(200):notNull,city:string(200):notNull"
 */
class m180622_080659_drop_country_division_city_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'country');
        $this->dropColumn('user', 'division');
        $this->dropColumn('user', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'country', $this->string(2)->notNull());
        $this->addColumn('user', 'division', $this->string(200)->notNull());
        $this->addColumn('user', 'city', $this->string(200)->notNull());
    }
}
