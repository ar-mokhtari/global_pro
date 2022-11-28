<?php
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Template\assets\Location;
Location::register($this);
?>
<!-- Background Image -->
<div class="bg-img" style="background-image: url('/image/5.png');">
    <div class="overlay"></div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="home-content sm-padding text-center">
            <h1 class="white-text">Checkout</h1>
        </div>
    </div>
</div>
<div class='row' style='padding-top:25px; padding-bottom:25px;'>
    <div class='col-md-12'>
        <div id='mainContentWrapper'>
            <div class="col-md-10 col-md-offset-1">
            
                <?php if($success = Tools::getFlash('success')): ?>
                <div class="alert alert-success"><span class="fa fa-check"></span> <?= $success ?></div>
                <?php endif; ?>

                <?php if($info = Tools::getFlash('info')): ?>
                <div class="alert alert-info"><span class="fa fa-exclamation"></span> <?= $info ?></div>
                <?php endif; ?>

                <?php if($warning = Tools::getFlash('warning')): ?>
                <div class="alert alert-warning"><span class="fa fa-exclamation-triangle"></span> <?= $warning ?></div>
                <?php endif; ?>

                <?php if($danger = Tools::getFlash('danger')): ?>
                <div class="alert alert-danger"><span class="fa fa-times"></span> <?= $danger ?></div>
                <?php endif; ?>

            <?php if (!$cart->getTotalCount()): ?>
                <h2 class="text-center">
                    Your Shopping Cart Is Empty
                </h2>
                <p class="text-center">
                    Continue your shopping by searching in site.<br>
                    You can start from <a href="<?= Tools::getBaseUrl() ?>">Home</a>.
                </p>
            <?php else: ?>
                <h2 class="text-center">
                    Review Your Order & Complete Checkout
                </h2>
                <hr/>
                <a href="<?= Tools::getBaseUrl(); //Tools::getPreviousUrl() ?>" 
                    class="btn btn-info" 
                    style="width: 100%;background: #716e67;border-color:#716e67">
                    Add More Products & Services
                </a>
                <hr/>

                <div class="shopping_cart">
                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <?= $this->render('cart/items.php', ['cart' => $cart]) ?>
                        </div>
                        <?php if (!Tools::isGuest()): ?>
                        <form action="<?= $cart->getSubmitOrderUrl() ?>" method="post" id="checkout_form" class="form-horizontal">
                            <?= Tools::getCsrfInput() ?>
                            <div class="panel panel-default">
                                <?= $this->render('cart/billing.php', ['cart' => $cart]) ?>
                            </div>
                            <div class="panel panel-default">
                                <?php /*<?= $this->render('cart/payment.php', ['cart' => $cart]) ?>*/ ?>
                                <?= $this->render('@app/modules/Codnitive/Adyen/views/cart/payment.php', ['cart' => $cart]) ?>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
