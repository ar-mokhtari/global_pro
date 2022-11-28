<?php

namespace app\modules\Codnitive\CentralOffice\models\coding;

use app\modules\Codnitive\Core\models\ActiveRecord;

class VwCodingrelation extends ActiveRecord
{
    public static function tableName()
    {
        return 'vw_coding_relation';
    }

    public function rules()
    {
        $rules = [
            [['first_code', 'second_code'], 'required'],
            [['id', 'first_code', 'second_code',], 'integer'],
            [['create_at', 'name_first'], 'string']
        ];
        return $rules;
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'first_code' => __('account', 'first_code_relation'),
            'second_code' => __('account', 'second_code_relation'),
            'id' => __('account', 'id'),
            'companyID' => __('account', 'companyID'),
            'create_at' => __('account', 'create_at'),
            'name_first' => __('account', 'name_first'),
        ];
    }


}