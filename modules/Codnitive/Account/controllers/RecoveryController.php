<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
// use yii\web\Controller;
use dektrium\user\controllers\RecoveryController as DektriumRecoveryController;
use app\modules\Codnitive\Account\models\RecoveryForm;
use yii\web\NotFoundHttpException;

class RecoveryController extends DektriumRecoveryController
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function beforeAction($action)
    {
        $this->layout = '@app/modules/Codnitive/Template/views/layouts/main';
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        $this->setBodyClass('account password-recovery orange');
        return parent::beforeAction($action);
    }

    /**
     * Shows page where user can request password recovery.
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRequest()
    {
        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException();
        }

        /** @var RecoveryForm $model */
        $model = \Yii::createObject([
            'class'    => RecoveryForm::className(),
            'scenario' => RecoveryForm::SCENARIO_REQUEST,
        ]);
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);
        $this->trigger(self::EVENT_BEFORE_REQUEST, $event);

        if ($model->load(\Yii::$app->request->post()) && $model->sendRecoveryMessage()) {
            $this->trigger(self::EVENT_AFTER_REQUEST, $event);
            return $this->redirect(tools()->getUrl('user/login'));
            // return $this->render('/message', [
            //     'title'  => \Yii::t('user', 'New password sent'),
            //     'module' => $this->module,
            // ]);
        }

        return $this->render('request', [
            'model' => $model,
        ]);
    }

}
