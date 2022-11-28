<?php

use yii\db\Migration;

/**
 * Handles adding cellphone_column_dob_column_gender_column_country_column_division_column_city_column_address to table `user`.
 */
class m180406_183718_add_fullname_column_cellphone_column_dob_column_gender_column_country_column_division_column_city_column_address_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'fullname', $this->string(32));
        $this->addColumn('user', 'cellphone', $this->string(14));
        $this->addColumn('user', 'dob', $this->date());
        $this->addColumn('user', 'gender', $this->boolean());
        $this->addColumn('user', 'country', $this->string(2));
        $this->addColumn('user', 'division', $this->string(200));
        $this->addColumn('user', 'city', $this->string(200));
        $this->addColumn('user', 'address', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'fullname');
        $this->dropColumn('user', 'cellphone');
        $this->dropColumn('user', 'dob');
        $this->dropColumn('user', 'gender');
        $this->dropColumn('user', 'country');
        $this->dropColumn('user', 'division');
        $this->dropColumn('user', 'city');
        $this->dropColumn('user', 'address');
    }
}
