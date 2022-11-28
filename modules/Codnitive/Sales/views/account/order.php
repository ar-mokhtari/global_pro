<?php

// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Calendar\models\Persian;

$invoiceNumber = $order->order_number;
$this->title = __('sales', 'Invoice #{invoice_number}', ['invoice_number' => $invoiceNumber]);
$this->params['breadcrumbs'][10] = $this->title;

$user    = tools()->getUser()->identity;
$billing = $order->billing_data;
if (is_string($billing)) {
    $billing = \yii\helpers\Json::decode($billing);
}

$items      = $order->getItems();
$grandTotal = $order->getGrandTotal($items);

$dateParts = explode(' ', tools()->getFormattedDate($order->order_date, 'Y-m-d H:i'));
$persianDate = str_replace('-', '/', (new Persian)->getDate($dateParts[0]));

?>

<div class="row my-order invoice">
    <div class="col-lg-12">
        <div class="card px-2">
            <div class="card-body">
                <div class="row">
                <h6 class="col-4 mt-4"><?= __('sales', 'Status:') ?> <?= $order->status_label ?></h6>
                <h3 class="col-8 text-right mt-4"><?= __('sales', 'Invoice&nbsp;&nbsp;#') ?> <?= $invoiceNumber ?></h3>
                <p class="col-12 text-right mb-5"><?= __('sales', 'Invoice Date:') ?> <?= $persianDate ?>&nbsp;<?= $dateParts[1] ?></p>
                <hr>
                </div>
                <div class="container-fluid d-flex justify-content-between">
                <div class="col-lg-3 pl-0">
                    <p class="mt-5 mb-2"><b><?= $user->fullname ?></b></p>
                    <?= $user->address ?><br>
                    <?= $user->location ?>
                    </p>
                </div>
                <div class="col-lg-3 pr-0">
                    <p class="mt-5 mb-2 text-right">
                        <b><?= __('sales', 'Invoice to:') ?> <?= $billing['firstname'] . ' ' . $billing['lastname'] ?></b><br>
                        <?= $billing['cellphone'] ?><br>
                        <?= $billing['email'] ?>
                    </p>
                    <p class="text-right">
                    <?= $billing['city'] ?><br>
                    <?= $billing['address'] ?><br>
                    </p>
                            
                    <?php if(!empty($billing['extra_data']) && !empty($billing['template'])): ?>
                    <?= $this->render($billing['template'], ['data' => $billing['extra_data']]) ?>
                    <?php endif; ?>
                </div>
                </div>
                <div class="container-fluid d-flex justify-content-between">
                <div class="col-lg-12 pl-0">
                    <?= $this->render('@app/modules/Codnitive/Sales/views/transaction.phtml', ['transaction' => $order->getOrderTransactions(), 'showMoreDetails' => true]) ?>
                    <?php /*if (!empty($order->payment_info)): ?>
                    <?php $module = strtolower($order->payment_method) ?>
                    <?php app()->getModule($module) ?>
                    <p>
                        <b><?= __('sales', 'Payment:') ?></b> <?= __($module, $order->payment_method) ?><br>
                        <?php foreach ($order->payment_info as $key => $val) : ?>
                            <?php $key = __($module, ucwords(str_replace('_', ' ', $key))) ?>
                            <?= "<b>$key</b>: $val" ?><br>
                        <?php endforeach; ?>
                    </p>
                    <?php endif*/ ?>
                </div>
                </div>
                
                <?= $this->render('order/items.php', ['items' => $items]); ?>

                <div class="container-fluid mt-5 w-100">
                    <h4 class="text-right mb-5"><?= __('sales', 'Total:') ?> <?= tools()->formatRial($grandTotal) ?></h4>
                </div>
                <?php /*<div class="container-fluid w-100">
                    <a href="#" class="btn btn-primary float-right mt-4 ml-2"><i class="mdi mdi-printer mr-1"></i>Print</a>
                    <a href="#" class="btn btn-success float-right mt-4"><i class="mdi mdi-telegram mr-1"></i>Send Invoice</a>
                </div>*/ ?>
            </div>
        </div>
    </div>
</div>
