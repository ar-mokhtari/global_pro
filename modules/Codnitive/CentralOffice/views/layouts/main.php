<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\modules\Codnitive\CentralOffice\blocks\CentralOffice;
$block = new CentralOffice;

$block->registerAssets($this, 'CentralOffice', 'CentralOfficeAssets');
$block->registerAssets($this, 'CentralOffice', 'TemplateMain');
$block->registerAssets($this, 'OfficeAutomation', 'MDPersianDatepicker');

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?php if (!empty($block->getLanguage())): ?>lang="<?= $block->getLanguage() ?>"<?php endif ?>>
<head>
    <script type="text/javascript">var BASE_URL = '<?= tools()->getUrl('', [], false, true, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
          content="">
    <?= tools()->csrfMetaTags() ?>
    <title><?= tools()->encode($this->title) ?></title>
    <?php $this->head() ?>

</head>
<body
    <?php if (!empty($this->context->getBodyId())): ?>id="<?= $this->context->getBodyId(); ?>"<?php endif ?>
    <?php if (!empty($this->context->getBodyClass())): ?>class="<?= $this->context->getBodyClass(); ?>"<?php endif ?>
>

<?php $this->beginBody() ?>
<?php
?>
<?php if (method_exists($this->context, 'renderHeaderBottom')): ?>
    <?= $this->context->renderHeaderBottom(); ?>
<?php endif; ?>

<?php require('console.phtml') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
