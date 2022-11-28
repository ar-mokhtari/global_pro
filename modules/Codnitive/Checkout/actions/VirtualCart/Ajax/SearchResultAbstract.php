<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart\Ajax;

// use yii\helpers\Json;

abstract class SearchResultAbstract extends AjaxAbstract
{
    protected $_repository = '';
    protected $_searchResultData = [];
    protected $_resultShowElementSelector = '.ajax-result-wrapper';
    protected $_toolbarClass = '';
    protected $_filterBlockClass = '';
    protected $_resultTemplateClass = '';
    protected $_renderTemplateDataKey = 'data';
    protected $_addDepartingSort = true;
    
    /**
     * get request form params and search to find items for product, then generates 
     * block template and return response
     */
    public function run()
    {
        $this->_getSearchResult();
        $listTemplateParams = [
            'data' => $this->_searchResultData,
            'resultTemplate' => isset($this->_searchResultData['error']) ? $this->_searchResultData['error'] : $this->_getResultTemplate(),
            'addDepartingSort' => $this->_addDepartingSort
        ];
        if (!empty($this->_toolbarClass)) {
            $listTemplateParams['toolbar'] = getObject($this->_toolbarClass);
        }
        if (!empty($this->_filterBlockClass)) {
            $listTemplateParams['filterBlock'] = getObject($this->_filterBlockClass, [$this->_searchResultData]);
        }
        $response = [[
            'element' => $this->_resultShowElementSelector,
            'type'    => 'html',
            'content' => $this->controller->renderAjax(
                '@app/modules/Codnitive/Template/views/templates/search/result/list.phtml',
                $listTemplateParams
            )
        ]];
        return $this->responseJson($response);

        // return Json::encode($response);
    }
    
    protected function _getResultTemplate(): string
    {
        return $this->controller->renderAjax(
            $this->_resultTemplateClass, 
            [
                $this->_renderTemplateDataKey => $this->_searchResultData, 
                'params' => $this->getCart(),
                'searchParams' => $this->getCart()
            ]
        );
    }

    abstract protected function _getSearchResult(): void;
}
