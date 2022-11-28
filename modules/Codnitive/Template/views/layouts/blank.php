<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Template', 'Main');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?php if (!empty($block->getLanguage())): ?>lang="<?= $block->getLanguage() ?>"<?php endif ?>>
<head>
    <script type="text/javascript">var BASE_URL = '<?= tools()->getUrl('', [], false, true, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="bilit.com official website, to book and buy train, airplane, hotel, flight, bus, car, event, insurance, tour, museum tickets">
    <?= tools()->csrfMetaTags() ?>
    <title><?= tools()->encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $block->registerAssets($this, 'Template', 'CustomCSS'); ?>
    <?php $block->registerAssets($this, 'Template', 'HeadJS'); ?>
</head>
<body 
    <?php if (!empty($this->context->getBodyId())): ?>id="<?= $this->context->getBodyId(); ?>"<?php endif ?> 
    <?php if (!empty($this->context->getBodyClass())): ?>class="<?= $this->context->getBodyClass(); ?>"<?php endif ?>
>

<?php $this->beginBody() ?>

<?= $this->render('html/_breadcrumbs.phtml'); ?>
<?= $this->render('html/_message.phtml'); ?>
<?= $content ?>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
