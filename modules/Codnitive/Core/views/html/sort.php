<?php

use app\modules\Codnitive\Template\helpers\Html;
use app\modules\Codnitive\Core\models\System\Source\Sort;

if (!isset($options) || empty($options)) {
    $options = (new Sort)->optionsArray();
}
$sortOrder = tools()->stripEscapeRequest(app()->getRequest())->get('sort');
if (!$sortOrder) {
    $sortOrder = 'current';
}
?>
<div class="search-box md-padding">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <select id="list_sort" class="d-inline-block col-lg-6 col-12">
                <?php foreach ($options as $value => $label): ?>
                    <option
                        value="<?= $value ?>"<?php if ($value == $sortOrder): ?>
                        selected="selected"<?php endif ?>>
                        <?= $label ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right small">
            <?= sprintf('<span>Showing %d-%d of %d items</span>', $from, $to, $total) ?>
        </div>

        <?php /*
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <i class="fa fa-list" aria-hidden="true"></i>
        <i class="fa fa-th" aria-hidden="true"></i>
        </div>
        */ ?>
    </div>
</div>
