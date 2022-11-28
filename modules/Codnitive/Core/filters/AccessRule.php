<?php

namespace app\modules\Codnitive\Core\filters;

class AccessRule extends \dektrium\user\filters\AccessRule
{
    /**
     * @inheritdoc
     * */
    protected function matchRole($user)
    {
        if (parent::matchRole($user)) {
            return true;
        }
        if (app()->user->isGuest) {
            return false;
        }

        foreach ($this->roles as $role) {
            switch ($role) {
                case 'superadmin':
                    return tools()->isSuperAdmin();
                    break;

                case 'agent':
                    return tools()->isAgent();
                    break;

                case 'reporter':
                    return tools()->isReporter();
                    break;
            }
        }

        return false;
    }
}
