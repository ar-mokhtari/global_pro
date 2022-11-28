<?php
use app\modules\Codnitive\Core\helpers\Tools;

?>
<!-- Background Image -->
<div class="bg-img" style="background-image: url('/image/5.png');">
    <div class="overlay"></div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="home-content sm-padding text-center">
            <h1 class="white-text">Success Checkout</h1>
        </div>
    </div>
</div>
<div class='row' style='padding-top:25px; padding-bottom:25px;'>
    <div class='col-md-12'>
        <div id='mainContentWrapper'>
            <div class="col-md-10 col-md-offset-1">
                <h2 class="text-center">
                    Your Order Was Successful
                </h2>
                <p class="text-center">
                    Your order number is: <?= $order->getOrderNumber(true) ?>
                    <br>
                    You can view your order details in your account.
                </p>
            </div>
        </div>
    </div>
</div>
