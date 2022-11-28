<?php 
use app\modules\Codnitive\Core\helpers\Tools;

$expired = $entity->expired();
// if ($entity->hasAttribute('start_date')) {
//     $expired = Tools::dateExpired($entity->start_date);
// }
?>
<div id="<?= $blockId ?>" style="display:none;">
    <?php if (empty($prices)): ?>
    <div class="alert alert-warning">All tickets sold out for this product.</div>
    <?php else: ?>
    <div class="box-detail-buy padding-2" style="margin-top: 20px">
        <div class="row">
            <div class="col-12 prices-list">
                <?php foreach ($prices as $price): ?>
                <?php if (empty($price->product_id)) continue ?>
                <div class="clearfix item-price">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <h3>
                            <?= $price->category_name ?>
                            <?php if ($price->is_popular): ?>
                            <div class="box-planning-label">
                                <svg class="box-planning-svg" x="0px" y="0px" viewBox="0 0 76.5 76.5" enable-background="new 0 0 76.5 76.5" xml:space="preserve">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4-11.4l76.5,76.5L76.4,76.5L0,0.1L11.4-11.4z"></path>
                                    </svg>
                                <span class="popular">POPULAR</span>
                            </div>
                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12">
                        <p class="text-center"><?= Tools::formatMoney($price->base_price) ?></p>
                    </div>
                    <?php if ($price->qty > 0): ?>
                        <div class="col-lg-3 col-md-3 col-sm-12">
                            <?php if (!$expired): ?>
                            <div class="input-group quantity">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="minus" disabled="disabled">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </span>
                                <input type="text" name="quantity[]" class="form-control input-number qty" value="1">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <?php if ($expired): ?>
                            <span class="btn btn-block btn-danger" disabled>Expired</span>
                            <?php else: ?>
                            <button class="btn btn-block btn-primary buy-now"  data-href="<?= $price->getAddToCartUrl() ?>">Buy Now</button>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <div class="col-lg-3 col-md-3 col-sm-12"></div>
                        <div class="col-lg-2 col-md-2 col-sm-12">
                            <span class="btn btn-block btn-warning">Sold Out</span>
                        </div>
                    <?php endif; ?>
                </div>
                <hr>
                <?php endforeach; ?>
            </div>
            <?php /*<div class="col-lg-4 col-md-4 col-sm-12">
                <div class="box-seat">
                    <img src="assets/image/images.jpg" alt="">
                </div>
            </div>*/ ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<script type="text/javascript">
    $('#<?= $blockId ?>').slideToggle();
</script>
