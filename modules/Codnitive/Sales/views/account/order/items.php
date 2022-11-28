<?php 
$grandTotal = $items[0]->getOrder()->grand_total;
if (!count($items)) return;
?>
<div class="container-fluid mt-5 d-flex justify-content-center w-100 items">
    <div class="table-responsive w-100">
    <table class="table">
        <thead>
            <tr class="bg-dark text-white">
                <th class="text-center"><?= __('sales', '#') ?></th>
                <th class="text-right"></th>
                <th class="text-right"><?= __('sales', 'Type') ?></th>
                <th class="text-right"><?= __('sales', 'Price') ?></th>
                <th class="text-center"><?= __('sales', 'Quantity') ?></th>
                <th class="text-right"><?= __('sales', 'Total') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $expandDetails = false /*tools()->isAdminPanel()*/ ?>
        <?php $i = 1; foreach ($items as $item): ?>
            <?php $viewDetails = !empty($item->product_data) && isset($item->product_data['template']) ?>
            <tr class="text-right order-item-row">
                <td class="text-center"><?= $i ?></td>
                <td class="text-right">
                    <?= $item->name ?>
                    <?php if ($viewDetails): ?>
                    <a class="mr-3 collapse-toggle <?php if (!$expandDetails): ?>collapsed<?php endif ?>" data-toggle="collapse" href="#view_detail_<?= $item->id ?>" role="button" aria-expanded="<?= $expandDetails ? 'true' : 'false' ?>" aria-controls="collapse">
                        <?= __('template', 'Details') ?>
                        <i class="fas fa-angle-up"></i>
                        <i class="fas fa-angle-down"></i>
                    </a>
                    <?php endif; ?>
                </td>
                <td class="text-right"><?= __('account', $item->ticket_type) ?></td>
                <td><?= tools()->formatRial($item->price) ?></td>
                <?php 
                    $qty = $item->qty;
                    $subTotal = $qty * $item->price;
                    if ($subTotal * $qty > $grandTotal) {
                        $qty = ceil($grandTotal / $item->price);
                        $subTotal = $grandTotal;
                    }
                ?>
                <td class="text-center"><?= $qty ?></td>
                <td><?= tools()->formatRial($subTotal) ?></td>
            </tr>
            <?php if ($viewDetails): ?>
            <tr class="text-right collapse <?php if ($expandDetails): ?>show<?php endif ?>" id="view_detail_<?= $item->id ?>">
                <td colspan="6">
                    <?= $this->render($item->product_data['template'], ['item' => $item]) ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php $i++ ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>