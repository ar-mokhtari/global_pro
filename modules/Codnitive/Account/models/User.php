<?php

namespace app\modules\Codnitive\Account\models;

use dektrium\user\models\User as BaseUser;
use yii\helpers\ArrayHelper;

class User extends BaseUser
{
    public const SCENARIO_SETTINGS = 'settings';
    public const GUEST_USER_ID = 100;

    public $cellphone;

    public function afterFind()
    {
        if (null === $this->cellphone) {
            $this->cellphone = $this->username;
            // $this->save();
        }
        // if (null === $this->credit_amount) {
            $this->credit_amount = (float) $this->credit_amount;
        // }
    }

    /** @inheritdoc */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['username', 'password'];
        return ArrayHelper::merge($scenarios, [
            self::SCENARIO_SETTINGS => ['username', 'email', 'password', 'fullname',
                'cellphone', 'dob', 'gender', /*'location', 'address'*/
            ]
        ]);
    }


    public function loadOne(int $id, array $where = [], array $fieldsToSelect = ['*'])
    {
        if (empty($where)) {
            $where = ['id' => $id];
        }
        $object = $this->find()->select($fieldsToSelect)->where($where)->limit(1)->one();
        if (!$object) {
            return new $this;
        }
        return $object;
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        //     // $rules['cellphoneRequired'] = ['cellphone', 'required'];
        //     // $rules['cellphoneLength']   = ['cellphone', 'string', 'max' => 11];
        //     // $rules['creditAmountDecimal'] = ['credit_amount', 'number'];
        unset($rules['emailRequired']);
        $rules['usernameUnique']['message'] = __('account', 'This cellphone has already been registered');
        // $rules['cellphoneRequired'] = ['cellphone', 'required', 'on' => ['register', 'connect', 'create', 'update']];
        $rules['emailUnique']['skipOnEmpty'] = true;
        return $rules;
    }
    
    public function searchByNameOrPhone(string $searchQuery): array
    {
        return $this->find()
            ->select(['id', 'username', 'fullname'])
            ->where(['like', 'username', "%$searchQuery%", false])
            ->orWhere(['like', 'fullname', "%$searchQuery%", false])
            ->asArray()
            ->all();
    }

    public function getUserSearchList(string $searchQuery): array
    {
        return $this->_formatUsersList($this->searchByNameOrPhone($searchQuery));
    }

    protected function _formatUsersList(array $users): array
    {
        $list = [];
        foreach ($users as $user) {
            $text  = $this->getSearchUserLable($user);
            $list[] = ['text' => $text, 'value' => $user['id']];
        }
        return $list;
    }

    public function getSearchUserLable(array $user = []): string
    {
        return empty($user) 
            ? "{$this->fullname} - {$this->username}"
            : "{$user['fullname']} - {$user['username']}";
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if (empty($this->email)) {
            $this->email = null;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return bool Whether the user is a superadmin or not.
     */
    public static function isSuperAdmin()
    {
        return in_array(self::$username, self::$module->superadmins);
    }

    /**
     * @return bool Whether the user is an agent or not.
     */
    public static function isAgent()
    {
        return in_array(self::$username, self::$module->agents);
    }

    /**
     * @return bool Whether the user is an agent or not.
     */
    public static function isReporter()
    {
        return in_array(self::$username, self::$module->reporters);
    }
}
