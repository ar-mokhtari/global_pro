<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

// use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Calendar\models\Gregorian;

abstract class ResultActionAbstract extends ActionAbstract
{
    protected $_searchParams = [];
    protected $_queryParams = [];
    // protected $_moduleId = '';
    protected $_repository;
    protected $_resultPageTemplate = '@app/modules/Codnitive/Template/views/templates/search/search_result.phtml';
    protected $_infoBlockTemplate = '@app/modules/Codnitive/Template/views/templates/search/_info.phtml';
    protected $_goingPathTemplate = '@app/modules/Codnitive/Template/views/templates/search/_info_going_path.phtml';
    protected $_loadingGif = 'search-loading-indicator.gif';
    // protected $_loadingGif = 'loading-anim-1.gif';
    protected $_searchingPhrase = 'Searching to find items...';
    protected $_infoIcon = 'fas fa-info fz-25';
    protected $_extraOptionsTemplate = '/templates/search/_extra_options.phtml';
    protected $_infoTitle = '';
    protected $_checkoutStep = '';
    protected $_breadcrumbs = '';
    protected $_breadcrumbsStep = 'result';
    protected $_breadcrumbsStepRound = 'round';
    protected $_color = 'orange';
    protected $_departureDateField = 'departing';

    public function run()
    {
        try {
            $this->_queryParams = tools()->stripOutInvisibles($this->_getRequest()->get());
            if (isset($this->_queryParams['dl']) && boolval($this->_queryParams['dl'])) {
                $this->removeCart();
            }
            if (1 == $this->_getRequest()->get('s') && true !== $this->isValidCartSession()) {
                return $this->isValidCartSession();
            }

            unset($this->_queryParams['lang']);
            app()->getModule($this->_moduleId);
            $cart = $this->getCart();
            $cartCandition = null !== $this->getStep() 
                && $this->_checkoutStep == $this->getStep()
                && isset($cart);
            if (empty($this->_queryParams) && $cartCandition) {
                $this->_searchParams = $cart;
                return $this->controller->redirect(tools()->getUrl($this->_checkoutStep, $this->_getRedirectParams()));
            }
            if (empty($this->_queryParams) && !isset($cart)) {
                $this->setFlash('warning', __('template', 'Please search again'));
                return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            }

            if ((!isset($this->_queryParams['s']) || !(bool) intval($this->_queryParams['s'])) /*&& !isset($cart)*/) {
                $this->_searchParams = $this->_getSearchParams();
            }
            else {
                $this->_searchParams = $cart;
            }
            if (empty($this->_searchParams)) {
                $this->setFlash('warning', __('template', 'Please search again'));
                return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            }

            if (isset($cart['registration_info'])) {
                $this->_searchParams['registration_info'] = $cart['registration_info'];
            }
            $__virtual_cart = [
                'step' => $this->_checkoutStep,
                $this->_moduleId => $this->_searchParams
            ];
            $this->setCart($__virtual_cart);

            $this->controller->addBodyClass($this->_getBodyClasses());
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
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_CAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        
        $renderParams['breadcrumbs'] = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => getObject($this->_breadcrumbs)->getBreadcrumbs($this->_getBreadcrumbsStep())]
        );
        $this->_registerAssets($this->controller->getView());
        return $this->controller->render($this->_resultPageTemplate, $renderParams);
    }

    protected function _getBreadcrumbsStep()
    {
        if ($this->_isRoundTripStep()) {
            return $this->_breadcrumbsStepRound;
        }
        return $this->_breadcrumbsStep;
    }

    protected function _getBodyClasses(): string
    {
        return "search-result {$this->_moduleId} {$this->_color}";
    }

    protected function _getRenderParams(): array
    {
        return [
            'params' => $this->_searchParams,
            'moduleId' => $this->_moduleId,
            'infoBlock' => $this->_getInfoBlock(),
            // 'animation_template' => $this->_searchingAnimationTemplate,
            'loadingGif' => $this->_loadingGif,
            'searchingPhrase' => __($this->_moduleId, $this->_searchingPhrase, $this->_searchParams)
        ];
    }

    protected function _getInfoBlock()
    {
        $params = [
            'params' => $this->_searchParams, 
            'moduleId' => $this->_moduleId,
            'icon' => $this->_infoIcon,
            'title' => __($this->_moduleId, $this->_infoTitle, $this->_searchParams),
            'extraOptions' => $this->_getExtraOptions(),
            'searchFormTemplate' => $this->_getSearchFormTemplate(),
            'hideSearchAgain' => $this->_isRoundTripStep()
        ];
        if ($this->_isRoundTripStep() && !empty($this->_goingPathTemplate)) {
            $params['goingPathTemplate'] = $this->_getFirstPathBlock();
        }
        return $this->controller->renderPartial($this->_infoBlockTemplate, $params);
    }

    protected function _getExtraOptions()
    {
        return !empty($this->_extraOptionsTemplate) 
            ? $this->controller->renderPartial($this->_extraOptionsTemplate, ['params' => $this->_searchParams])
            : '';
    }

    protected function _getSearchFormTemplate()
    {
        foreach ((new \app\modules\Codnitive\Template\blocks\Home)->getConfigs() as $moduleConfig) {
            if ($moduleConfig['module'] === $this->_moduleId) {
                return $this->controller->renderPartial($moduleConfig['template'], ['params' => $this->_searchParams]);
            }
        }
        return '';
    }

    protected function _registerAssets(\yii\web\View $pageRender): Template
    {
        $block  = new Template;
        $block->registerAssets($pageRender, 'Template', 'PriceRange');
        $block->registerAssets($pageRender, 'Template', 'Isotope');
        $block->registerAssets($pageRender, 'Template', 'LazyLoad');
        $block->registerAssets($pageRender, 'Template', 'StickySidebar');
        return $block;
    }
    
    protected function _getSearchParams(): array
    {
        $cart = $this->getCart();
        // if (isset($cart['going_path']) && !isset($this->_queryParams['day'])) {
        //     $cart = $cart['going_path'];
        // }
        if (isset($this->_queryParams['day']) && $this->_queryParams['day']) {
            $cart[$this->_departureDateField.'_persian'] = $date = $this->_queryParams[$this->_departureDateField];
            $cart[$this->_departureDateField] = (new Gregorian)->getDate($date);
        }
        return $cart ?? [];
    }

    abstract protected function _getPageTitle(): string;
    
    // abstract protected function _getSearchParams(): array;

    abstract protected function _getRedirectParams(): array;
}
