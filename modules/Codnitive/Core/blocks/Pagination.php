<?php

namespace app\modules\Codnitive\Core\blocks;

use Yii;
use yii\data\Pagination as BasePagination;
use yii\widgets\LinkPager;

class Pagination
{
    private $_pages;

    public function __construct($count, $pageSize = 10)
    {
        $this->_pages = new BasePagination([
            'totalCount' => $count,
        ]);
        $this->setPageSize($pageSize);
    }

    public function toHtml()
    {
        return LinkPager::widget([
            /** 
             * More options here:
             * https://www.yiiframework.com/doc/api/2.0/yii-widgets-linkpager
             * 
             * Sample options: 
             * 
             * 'pagination' => $pages,
             * //Css option for container
             * 'options' => ['class' => ''],
             * //First option value
             * 'firstPageLabel' => '&nbsp;',
             * //Last option value
             * 'lastPageLabel' => '&nbsp;',
             * //Previous option value
             * 'prevPageLabel' => '&nbsp;',
             * //Next option value
             * 'nextPageLabel' => '&nbsp;',
             * //Current Active option value
             * 'activePageCssClass' => 'p-active',
             * //Max count of allowed options
             * 'maxButtonCount' => 8,
             * 
             * // Css for each options. Links
             * 'linkOptions' => ['class' => ''],
             * 'disabledPageCssClass' => 'disabled',
             * 
             * // Customzing CSS class for navigating link
             * 'prevPageCssClass' => 'p-back',
             * 'nextPageCssClass' => 'p-next',
             * 'firstPageCssClass' => 'p-first',
             * 'lastPageCssClass' => 'p-last',
             */
            'pagination'            => $this->getPages(),
            'pageCssClass'          => 'paginate',
            'prevPageLabel'         => 'Previous',
            'nextPageLabel'         => 'Next',
            'disabledPageCssClass'  => 'disabled',
            'prevPageCssClass'      => 'page-item prev previous',
            'nextPageCssClass'      => 'page-item next',
            // 'activePageCssClass'    => 'active has-success',
            'linkContainerOptions'  => ['class' => 'page-item'],
            'linkOptions'           => ['class' => 'page-link'],
        ]);
    }

    public function setPageSize($size = 10)
    {
        $this->_pages->setPageSize($size);
    }

    public function getPages()
    {
        return $this->_pages;
    }

    public function getLimit()
    {
        return $this->getPages()->limit;
    }

    public function getOffset()
    {
        return $this->getPages()->offset;
    }

    public function getPage()
    {
        return $this->getOffset() / $this->getLimit() + 1;
    }

    public function getShowingItems()
    {
        $to    = $this->getOffset() + $this->getLimit();
        $total = $this->getPages()->totalCount;
        return [
            'from'  => $this->getOffset() + 1,
            'to'    => ($to < $total) ? $to : $total,
            'total' => $total
        ];
    }
}
