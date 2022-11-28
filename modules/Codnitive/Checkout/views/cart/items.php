<?php
use app\modules\Codnitive\Core\helpers\Tools;
// echo '<pre>';
// foreach($cart->getItems() as $item) {
//     var_dump($item->getProduct()->name);
//     var_dump($item->getPrice());
// }
// var_dump($cart->getTotalCost());
?>

<div class="panel-heading">
    <h4 class="panel-title">
        <a  data-toggle="collapse"
            data-parent="#accordion"
            href="#collapseOne"
            style="display: block;">
                Review Your Order
        </a>
    </h4>
</div>
<div id="collapseOne" class="panel-collapse collapse in">
    <div class="panel-body">
        <div class="items">
            <div class="col-md-9">
                <form id="cart_items_form" action="<?= $cart->getUpdateUrl() ?>" method="post">
                    <?= Tools::getCsrfInput() ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right">
                                    <a href="<?= $cart->getClearUrl() ?>" class="btn btn-default clear-cart" role="button">Clear Cart</a>
                                    <input type="submit" class="btn btn-default update-cart" value="Update Cart">
                                </td>
                                <td class="text-right"><strong><?= Tools::formatNumber($cart->getTotalCost()) ?></strong></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php foreach ($cart->getItems() as $item): ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="<?= $item->getRemoveUrl() ?>" title="Remove Item"><i class="fa fa-trash color-red"></i></a>
                                    </td>
                                    <td class="text-left"><?= $item->getProduct()->getName() ?></td>
                                    <td class="text-right"><?= Tools::formatNumber($item->getPrice()) ?></td>
                                    <td class="text-center col-xs-1">
                                        <input  value="<?= $item->getQuantity() ?>"
                                                name="item_qty[<?= $item->getProduct()->id ?>]"
                                                class="text-center"
                                                type="number"
                                                min="0">
                                    </td>
                                    <td class="text-right"><?= Tools::formatNumber($item->getCost()) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="col-md-3">
                <div style="text-align: center;">
                    <h3>Order Total</h3>
                    <h3><span style="color:green;"><?= Tools::formatMoney($cart->getTotalCost()) ?></span></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-heading text-center">
    <?php if (Tools::isGuest()): ?>
        <h4 class="panel-title" style="margin-bottom: 5px; width:100%;">
            <a  style="width:100%; color: #fff"
                href="<?= Tools::getUrl('user/login', ['remember_cart' => 1]) ?>"
                class="btn btn-success">
                    Login to Process Checkout »
            </a>
        </h4>
        <a href="<?= Tools::getUrl('user/register', ['remember_cart' => 1]) ?>"
            class="small">
            Don't have an account? Sign up!
        </a>
    <?php else: ?>
        <h4 class="panel-title" style="width:100%;">
            <a  style="width:100%; color: #fff"
                data-toggle="collapse"
                data-parent="#accordion"
                href="#collapseOne"
                class="btn btn-success"
                onclick="$('#collapseTwo').fadeIn();">
                    Continue to Billing Information »
            </a>
        </h4>
    <?php endif; ?>
    </div>
</div>
