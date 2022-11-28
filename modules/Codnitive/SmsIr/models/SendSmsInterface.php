<?php 
namespace app\modules\Codnitive\SmsIr\models;

interface SendSmsInterface
{
    public function setParameters(array $parameters);
    public function getParameters(): array;

    public function setCellphoneNumber($cellphone);
    public function getCellphoneNumber();

    public function setTemplate($temlateId);
    public function getTemplate();

    public function execWhiteSms(): array;
    public function execBatchSms(): array;
    public function send(\yii\base\Event $event);
    public function sendWhiteSms(\yii\base\Event $event): array;
    public function sendBatchSms(\yii\base\Event $event): array;
}
