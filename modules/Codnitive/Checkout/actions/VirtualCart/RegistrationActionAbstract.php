<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

use yii\helpers\ArrayHelper;
// use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
// use app\modules\Codnitive\Core\models\DynamicModel;

abstract class RegistrationActionAbstract extends ActionAbstract
{
    // protected $_moduleId = '';
    protected $_resultPageTemplate = '';
    protected $_checkoutStep = '';
    protected $_breadcrumbs = '';
    protected $_breadcrumbsStep = 'info';
    protected $_registrationFormModel = '';
    protected $_userInfoField = 'customer_info';
    protected $_color = 'orange';
    protected $_backUrl = '';

    public function run()
    {
        try {
            // if (null === $this->getCart()) {
            //     $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            //     return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            // }
            if (!empty($this->_backUrl)) {
                return $this->controller->redirect($this->_backUrl);
            }
            if (true !== $this->isValidCartSession()) return $this->isValidCartSession();

            app()->getModule($this->_moduleId);
            $this->_updateCart();

            $this->controller->setBodyClass($this->_getBodyClasses());
            $this->controller->view->title = $this->_getPageTitle();
            $renderParams = $this->_getRenderParams();
        }
        catch (\yii\db\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_RAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_RAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        
        $renderParams['breadcrumbs'] = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => getObject($this->_breadcrumbs)->getBreadcrumbs($this->_breadcrumbsStep)]
        );
        return $this->controller->render($this->_resultPageTemplate, $renderParams);
    }

    protected function _updateCart()
    {
        return $this;
    }

    protected function _getBodyClasses(): string
    {
        return "registration checkout {$this->_moduleId} {$this->_color}";
    }

    protected function _getRenderParams(): array
    {
        return [
            'model' => $this->_getFormModel(),
        ];
    }

    protected function _getFormModel()
    {
        $info  = [];
        $model = getObject($this->_registrationFormModel);
        $busData = $this->getCart();
        if (isset($busData[$this->_userInfoField])) {
            $info = $busData[$this->_userInfoField];
            unset($info['terms']);
        }
        else if (!tools()->isGuest()) {
            $info = ArrayHelper::merge(
                tools()->getUser()->identity->getAttributes(), 
                tools()->getUserNameParts()
            );
        }
        $model->setAttributes($info);
        return $model;
    }

    abstract protected function _getPageTitle(): string;
}
