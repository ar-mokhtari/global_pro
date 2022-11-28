<?php

namespace app\modules\Codnitive\CentralOffice\models\coding;

use app\modules\Codnitive\Core\models\ActiveRecord;

class Codingrelation extends ActiveRecord
{
    public static function tableName()
    {
        return 'coding_relation';
    }

    protected $_fieldsToSelect = [
        'first_code', 'second_code'
    ];


    public function rules()
    {
        $rules = [
            [['first_code', 'second_code'], 'required'],
            [['first_code', 'second_code'], 'integer'],
        ];
        return $rules;
    }

    public function getField()
    {
        return $this
            ->getCollection($this->_fieldsToSelect);
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
        ];
    }


}