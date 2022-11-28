<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart\Ajax;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\SmsIr\models\SmsParams;

abstract class SuccessTicketingAbstract extends AjaxAbstract
{
    // protected $_moduleId = '';
    protected $_ticketWrapperTemplate = '';
    protected $_resultShowElementSelector = '#success_ticket_wrapper';
    protected $_repositoryModelClassName = '';
    protected $_params = [];
    protected $_renderParams = [];
    protected $_cart = [];
    protected $_bookingStatus = [];
    protected $_smsSender = '';
    protected $_reservationType = 'reservation';
    protected $repository;
    protected $order;
    protected $ticketInfo;
    protected $ticketPrintData;
    protected $gateway;
    protected $_googleTagManagerClass = '';

    public function init()
    {
        parent::init();
        app()->getModule($this->_moduleId);
        app()->getModule('wallet');
        $this->_reservationType = $this->_getRequest()->post('rt');
        $this->_cart   = $this->getCart();
        $this->_params = app()->session->get('success_params');
        $this->gateway = app()->session->get('gateway');
        $this->order   = (new Order)->loadOne($this->_params['ResNum']);
    }

    public function run()
    {
        try {
            $this->_bookingStatus = $this->_processBooking();
            if ($this->_bookingStatus['ticket_number'] === false && 'revert' == $this->_bookingStatus['action']) {
                return $this->_revertAction($this->_bookingStatus['message']);
            }
            else if ($this->_bookingStatus['ticket_number'] !== false && 'success' == $this->_bookingStatus['action']) {
                $this->_successAction();
            }
            else if ('continue' == $this->_bookingStatus['action'] && isset($this->_bookingStatus['message'])) {
                $this->setFlash('warning', $this->_bookingStatus['message']);
            }
            
            $this->_cleanUpSessions();
            app()->session->set('success_checkout', true);
        }
        catch (\yii\db\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_A_STA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_A_STA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        return $this->responseJson($this->_getResponseBlocks());
    }

    protected function _getResponseBlocks(): array
    {
        $this->_getRenderParams();
//         $otherBlock = $this->_reservationType == 'reservation' ? 'reservation_return' : 'reservation';
//         $js = <<<JS
//             <script type="text/javascript">
//                 $(document).ready(function () {
//                     $('#$this->_reservationType').addClass('loaded');
//                     if ($('#$otherBlock').hasClass('loaded')) {
//                         $('$this->_resultShowElementSelector > .countdown:first-child').remove();
//                     }
//                 });
//             </script>
// JS;
        $js = <<<JS
            <script type="text/javascript">
                $(document).ready(function () {
                    $('$this->_resultShowElementSelector > .countdown:first-child').remove();
                });
            </script>
JS;
        $blocks = [
            [
                'element' => $this->_resultShowElementSelector . ' #' . $this->_reservationType,
                'type'    => 'html',
                'content' => $this->controller->renderAjax(
                    $this->_ticketWrapperTemplate,
                    $this->_renderParams
                )
            ],
            [
                'element' => $this->_resultShowElementSelector . ' #' . $this->_reservationType,
                'type'    => 'append',
                'content' => $js
            ],
        ];

        if (!empty($this->_googleTagManagerClass)) {
            $blocks[] = [
                'element' => $this->_resultShowElementSelector . ' #' . $this->_reservationType,
                'type'    => 'append',
                'content' => $this->controller->renderPartial(
                    '@app/modules/Codnitive/Checkout/views/templates/process/success/google_tag_manager.js.phtml'
                )
            ];
        }

        return $blocks;
    }

    protected function _processBooking(): array
    {
        $provider         = $this->_cart[$this->_reservationType]['provider'];
        $this->repository = getObject($this->_repositoryModelClassName, [$provider]);
        $bookingResult = $this->repository->bookTicket($this->_cart, $this->order, $this->_reservationType);
        if ($bookingResult['ticket_number'] !== false) {
            $this->order->saveTicketIdToItems($bookingResult['ticket_number']);
        }
        $this->order->setAttribute('booking_result', $bookingResult);
        $this->order->save();
        return $bookingResult;
    }

    protected function _revertAction(string $error)
    {
        $revertTransaction = $this->gateway->revertTransaction(
            $this->_params['RefNum'], 
            $this->order->id,
            $this->order->getOrderNumber()
        );
        $this->setFlash('warning', $revertTransaction['message']);
        $this->_cancelCheckoutAction($error);
    }

    protected function _cancelCheckoutAction(string $error)
    {
        $this->order->setOrderCanceled()->save();
        $this->_cleanUpSessions();
        $this->setFlash('danger', $error);
        return $this->responseJson($this->_getResponseBlocks());
    }

    protected function _successAction()
    {
        $this->ticketInfo = $this->_getTicketInfo();
        $this->ticketInfo['ticket_id'] = $this->_bookingStatus['ticket_number'];
        
        $updateOrderStatus = $this->order->saveTicketItemsData($this->_getOrderItemData());
        $this->order->setOrderCompleted()->save();
        $this->ticketPrintData = $this->repository->getAllTicketsPrintData($this->order, $this->_reservationType);
        $this->sendSms();

        !$updateOrderStatus 
            ? $this->setFlash('warning', __('template', 'We couldn\'t issue ticket, please save or print this information.'))
            : $this->setFlash('success', $this->_bookingStatus['message']);
        
        return $this;
    }

    protected function _cleanUpSessions(): self
    {
        $this->removeCart();
        app()->session->remove('payment_params');
        app()->session->remove('success_params');
        app()->session->remove('gateway');
        return $this;
    }

    protected function sendSms(): void
    {
        $params = $this->_getSmsParams();
        $smsData = new SmsParams;
        $smsData->cellphone  = $params['cellphone'];
        unset($params['cellphone']);
        $smsData->params = $params;
        $smsData->templateId = $this->_smsSender::SMS_TEMPLATE_ID;
        $smsData->messages   = $this->_smsSender::getMessage($smsData->params);
        app()->trigger($this->_smsSender::SUCCESS_CHECKOUT_AFTER_TICKET_ISSUE_SEND_SMS, $smsData);
    }

    protected function _getRenderParams(): void
    {
        if ($this->_bookingStatus['ticket_number'] === false) {
            $this->_renderParams = [
                'hasError' => true,
                'moduleId' => $this->_moduleId
            ];
        }
        else {
            $this->_renderParams = [
                'hasError' => false,
                'ticket' => $this->ticketPrintData ?? [],
                'moduleId' => $this->_moduleId
            ];
        }
    }

    abstract protected function _getOrderItemData(): array;
    abstract protected function _getTicketInfo(): array;
    abstract protected function _getSmsParams(): array;
}
