<?php 
namespace app\modules\Codnitive\SmsIr\observers;

class SendSms extends \yii\base\Component implements SendSmsObserverInterface
{
    protected $_modules = [
        'app\modules\Codnitive\CentralOffice',
    ];

    public function runObservers(): self
    {
        foreach ($this->_modules as $modulePath) {
            $className = "$modulePath\observers\SendSms";
            (new $className)->runObservers();
        }
        $this->generalObservers();
        return $this;
    }

    /**
     * You can declear public observers here
     * 
     * Sample:
     * 
     * use Yii;
     * use yii\base\Event;
     * use app\components\Foo;
     *
     * Yii::$app->on('bar', function ($event) {
     *     echo get_class($event->sender);  // displays "app\components\Foo"
     * });
     */
    public function generalObservers(): self
    {
        return $this;
    }
}
