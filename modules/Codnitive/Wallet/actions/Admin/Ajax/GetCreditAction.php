<?php

namespace app\modules\Codnitive\Wallet\actions\Admin\Ajax;

/**
 * Method which calls with ajax to get select user current credit
 * 
 * @route   admin/wallet/ajax/getCredit
 */
class GetCreditAction extends \app\modules\Codnitive\Core\actions\Action
{
    protected $_realModuleId = \app\modules\Codnitive\Coupon\Module::MODULE_ID;

    public function run()
    {
        $userCredit = floatval(
            (new \app\modules\Codnitive\Account\models\User)->loadOne(
                intval($this->_getRequest()->post('id'))
            )->credit_amount
        );

        $js = <<<JS
        <script>
        $('#credit_amount').val($userCredit);
        $('#credit_amount_price_field .price').html(
            codnitive.formatRial($userCredit || 0)
        );
        </script>
JS;
        $html = [
            [
                'element' => '#user_current_credit',
                'type' => 'html',
                'content' => $this->controller->renderAjax(
                    '/templates/admin/credit/_wallet_info.phtml',
                    ['credit' => $userCredit]
                ),
            ],
            [
                'element' => '#user_current_credit',
                'type' => 'append',
                'content' => $js
            ]
        ];
        return $this->responseJson($html);
    }
}
