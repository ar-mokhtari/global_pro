<?php

namespace app\modules\Codnitive\CentralOffice\models\coding;

use app\modules\Codnitive\Core\models\ActiveRecord;

class Coding extends ActiveRecord
{
    public static function tableName()
    {
        return 'coding';
    }

    public function rules()
    {
        $rules = [
            [['code', 'grp', 'name', 'parent', 'level', 'active'], 'required'],
            [['code'], 'number'],
            [['grp', 'level', 'user_create'], 'integer'],
            [['make_date',], 'string'],
            [['active',], 'number'],
        ];
        return $rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => __('account', 'id'),
            'code' => __('account', 'code'),
            'grp' => __('account', 'grp'),
            'name' => __('account', 'name'),
            'level' => __('account', 'level'),
            'user_create' => __('account', 'user_create'),
            'make_date' => __('account', 'make_date'),
            'active' => __('account', 'active'),
            'parent' => __('account', 'parent'),
        ];
    }



}