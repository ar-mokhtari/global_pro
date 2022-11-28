<?php

use app\modules\Codnitive\Core\helpers\Html;
use app\modules\Codnitive\Core\helpers\Tools;

$this->title = __('sales', 'My Orders List');
// $this->params['breadcrumbs'][10] = __('sales', 'Orders');

?>

<div class="card-body-account">
    <h4><?= __('account', 'Orders') ?></h4>
    <div class="right-content">
        <div class="mt-4">
            <div class="d-flex flex-column">
                <div class="card mb-3 received-orders orders-grid">
                    <div class="d-flex flex-row justify-content-between p-3 align-items-center bd-bottom">
                        <span class=""> <?= __('account', 'Recent Orders') ?></span>
                        <i class="fas fa-list blue"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive py-4 px-2 data-table grid orders-grid-table">
                            <?php \yii\widgets\Pjax::begin([/*'enablePushState' => false, */'timeout' => 5000]); ?>
                                <?= Html::getGridPerPage($orderGrid->showResetFilterButton(), Tools::getPerPageSize()); ?>
                                <?= $orderGrid->toHtml(); ?>
                            <?php \yii\widgets\Pjax::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix "></div>
        </div>
    </div>
</div>

