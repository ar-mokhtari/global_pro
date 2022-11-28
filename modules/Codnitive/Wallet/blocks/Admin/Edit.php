<?php 

namespace app\modules\Codnitive\Wallet\blocks\Admin;

class Edit extends \app\modules\Codnitive\Admin\blocks\EditAbstract
{
    protected $_module = \app\modules\Codnitive\Wallet\Module::MODULE_ID;
    protected $_formFieldTemplate = '@app/modules/Codnitive/Wallet/views/templates/admin/credit/edit.phtml';

    public function getBackUrl(): string
    {
        return tools()->getUrl("admin/dashboard");
    }
}
