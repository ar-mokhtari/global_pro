<?php

namespace app\modules\Codnitive\Core\models\Grid;

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;
// use app\modules\Codnitive\Core\helpers\Tools;

abstract class GridAbstract
{
    const PAGE_SIZE             = 10;
    
    protected $_limit           = 0;
    // protected $_modelClass      = '\app\modules\Codnitive\Core\models\ActiveRecord';
    protected $_modelClass      = '';
    protected $_searchModel     = '';
    protected $_columns         = [];
    protected $_sortAttributes  = ['id'];
    protected $_key             = 'id';
    protected $_pageSize        = self::PAGE_SIZE;
    protected $_removePager     = false;
    protected $_actionsTemplate = '{view}  {update}  {delete}';
    protected $_modelObject;

    public function __construct()
    {
        $this->_modelObject = new $this->_modelClass;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    public function getPageSize()
    {
        if ($pageSize = tools()->getPerPageSize()) {
            $this->_pageSize = $pageSize;
        }
        return $this->_pageSize;
    }

    public function getDataProvider()
    {
        $allModels = $this->_getDataCollection();
        if (!empty($this->_searchModel)) {
            $allModels = $this->getSearchModel()->search(
                $this->_getSearchParams(),
                $this->_prepareDataCollection($this->_columns)
            );
        }
        return new ArrayDataProvider([
            'allModels' => $allModels,
            'pagination' => [
                'pageSize' => tools()->getPerPageSize(),
            ],
            'sort' => [
                'attributes' => $this->_sortAttributes,
            ],
            'key' => $this->_key
        ]);
    }

    public function getSearchModel()
    {
        $searchModel = new $this->_searchModel;
        $searchModel->setAttributes($this->_getSearchParams());
        return $searchModel;
    }

    public function showResetFilterButton()
    {
        return !empty($this->_searchModel);
    }

    protected function _getSearchParams()
    {
        return tools()->stripEscapeRequest(app()->getRequest())->get($this->_getFilterNamespace(), []);
    }

    protected function _getFilterNamespace()
    {
        $classNamePartsArray = explode('\\', $this->_searchModel);
        return end($classNamePartsArray);
    }

    protected function _prepareDataCollection($columns = [])
    {
        $collection = $this->_modelObject
            ->removeCollectionLimit();
        if ($this->_limit) {
            $collection->setLimit($this->_limit);
        }
        return $collection->setOrderBy(['id' => SORT_DESC])
            ->prepareCollection($columns);
    }

    protected function _getDataCollection()
    {
        $collection = $this->_prepareDataCollection($this->_columns)->all();
        foreach ($collection as &$object) {
            $data = $this->_modelObject->jsonDecodeFields($object);
            $object->setAttributes($data);
        }
        return $collection;
    }

    public function toHtml()
    {
        return GridView::widget($this->_getGridConfig());
    }

    protected function _getGridConfig(): array
    {
        $config = [
            'dataProvider'  => $this->getDataProvider(),
            'columns'       => $this->_getColumns(),
        ];
        if (!$this->_removePager) {
            $config['pager'] = [
                'prevPageLabel'         => __('template', 'Previous'),
                'nextPageLabel'         => __('template', 'Next'),
                'disabledPageCssClass'  => 'disabled',
                'prevPageCssClass'      => 'paginate_button prev previous',
                'nextPageCssClass'      => 'paginate_button next',
                'pageCssClass'          => 'paginate_button',
                'hideOnSinglePage'      => false
                // 'options' => ['class' => 'pagination'],
                // 'rowOptions' => function ($model, $key, $index, $grid) {
                //     return [
                //         'class' => 'dropdown-item',
                //         'style' => "cursor: pointer",
                //         'onclick' => 'location.href="'.$this->_getRowUrl($model, $key).'"',
                //     ];
                // },
            ];
        }
        if (!empty($this->_searchModel)) {
            $config['filterModel'] = $this->getSearchModel();
        }
        return $config;
    }

    protected function _getColumns()
    {
        $columns   = $this->_prepareColumnsFormat();
        if (!empty($this->_getActionButtons()) && !empty($this->_actionsTemplate)) {
            $columns[] = $this->_getActionsColumn();
        }
        return $columns;
    }

    protected function _prepareColumnsFormat()
    {
        return $this->_columns;
    }

    protected function _getActionsColumn()
    {
        return [
          'class'           => 'yii\grid\ActionColumn',
          'header'          => __('template', 'Actions'),
          'template'        => $this->_actionsTemplate,
          'buttons'         => $this->_getActionButtons(),
          'contentOptions'  => ['class' => 'text-center col-action'],
          'headerOptions'   => ['class' => 'text-center col-action-header'],
          'urlCreator'      => function ($action, $model, $key, $index) {
              return static::_getActionUrls($action, $model, $key, $index);
          }
      ];
    }

    protected function _getActionButtons()
    {
        return [
          'view' => function ($url, $model) {
              return Html::a('<span class="fa fa-eye"></span>', $url, [
                  'title' => __('template', 'View'),
              ]);
          },
          'update' => function ($url, $model) {
              return Html::a('<span class="fa fa-pencil"></span>', $url, [
                  'title' => __('template', 'Update'),
              ]);
          },
          'delete' => function ($url, $model) {
              $html = '<a href="javascript:;" onclick="tixox.deleteGridRow(\''.$url.'\')">
                <span class="fa fa-trash"></span>
              </a>';
              return $html;

              // return Html::a('<span class="fa fa-trash"></span>', $url, [
              //     'title' => __('app', 'Delete'),
              // ]);
          }
      ];
    }

    protected abstract function _getActionUrls($action, $model, $key, $index);
    // protected function _getActionUrls($action, $model, $key, $index)
    // {
    //     switch ($action) {
    //         case 'view':
    //             $url = app()->request->url . '/view';
    //             break;
    //
    //         case 'update':
    //             $url = Tools::getUrl('update');
    //             break;
    //
    //         case 'delete':
    //             $url = Tools::getUrl('delete');
    //             break;
    //     }
    //     return $url;
    // }
}
