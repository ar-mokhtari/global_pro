<?php

namespace app\modules\Codnitive\Core\filters;

class AccessControl extends \yii\filters\AccessControl
{
    public function beforeAction($action)
    {
        foreach ($this->rules as $rule) {
            if (!in_array($action->id, $rule->actions)) continue;
            foreach ($rule->roles as $role) {
                $roleProperty = "{$role}s";
                $condition = $this->user->identity 
                    && isset(app()->getModule('user')->$roleProperty) 
                    && in_array($this->user->identity->username, app()->getModule('user')->$roleProperty);
                if ($condition) {
                    return true;
                }
            }
        }
        return parent::beforeAction($action);
    }
}
