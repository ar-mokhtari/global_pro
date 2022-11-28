<?php 
namespace app\modules\Codnitive\SmsIr\models;

abstract class SendSmsAbstract implements SendSmsInterface
{
    public const SUCCESS_CHECKOUT_ISSUE_TICKET_AFTER_SEND_SMS = 'success_checkout_issue_ticket_after_send_sms';
    
    /**
     * List of parameters with values of variables for using fast white SMS API
     * 
     * @var array
     */
    protected $_parameters;

    /**
     * Cellphone for using fast white SMS API
     * Cellphones list for using with simple SMS API
     * 
     * @var string|array
     */
    protected $_cellphone;

    /**
     * Template ID for using fast white SMS API
     * Template messages list for using with simple SMS API
     * 
     * @var int|array
     */
    protected $_template;

    public function setParameters(array $parameters): self
    {
        $this->_parameters = $parameters;
        return $this;
    }

    public function getParameters(): array
    {
        return $this->_parameters;
    }

    public function setCellphoneNumber($cellphone): self
    {
        $this->_cellphone = $cellphone;
        return $this;
    }

    public function getCellphoneNumber()
    {
        return $this->_cellphone;
    }

    public function setTemplate($template): self
    {
        $this->_template = $template;
        return $this;
    }
    public function getTemplate()
    {
        return $this->_template;
    }

    public function execWhiteSms(): array
    {
        return (new WhiteSms)->ultraFastSend(
            $this->getTemplate(),
            $this->getCellphoneNumber(),
            $this->getParameters()
        );
    }

    public function execBatchSms(): array
    {
        return (new BatchSms)->sendMessage(
            $this->getTemplate(),
            $this->getCellphoneNumber()
        );
    }

    public function send(\yii\base\Event $event): array
    {
        if ($event->forceUseBatchSms) {
            return $this->sendBatchSms($event);
        }
        $result = $this->sendWhiteSms($event);
        if (!isset($result['IsSuccessful']) || !$result['IsSuccessful']) {
            return $this->sendBatchSms($event);
        }
        return $result;
    }

    public function sendWhiteSms(\yii\base\Event $event): array
    {
        return $this->setParameters($event->params)
                ->setTemplate($event->templateId)
                ->setCellphoneNumber($event->cellphone)
                ->execWhiteSms();
    }
    
    public function sendBatchSms(\yii\base\Event $event): array
    {
        return $this->setTemplate([$event->messages])
                ->setCellphoneNumber([$event->cellphone])
                ->execBatchSms();
    }

    public static function getMessage(array $params): string
    {
        $message = __(static::MODULE_ID, static::SMS_TEMPLATE);
        foreach ($params as $param) {
            $variable = $param['Parameter'];
            $message  = str_replace("[$variable]", $param['ParameterValue'], $message);
        }
        return $message;
    }
}
