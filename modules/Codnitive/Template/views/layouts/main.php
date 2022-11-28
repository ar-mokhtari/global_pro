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
    <meta name="description" content="Rayka Tejarat Rahe Abrisham">
    <?= tools()->csrfMetaTags() ?>
    <title><?= tools()->encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $block->registerAssets($this, 'Template', 'CustomCSS'); ?>
    <?php $block->registerAssets($this, 'Template', 'HeadJS'); ?>
    <?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_before_head_end.phtml') ?>
</head>
<body 
    <?php if (!empty($this->context->getBodyId())): ?>id="<?= $this->context->getBodyId(); ?>"<?php endif ?> 
    <?php if (!empty($this->context->getBodyClass())): ?>class="<?= $this->context->getBodyClass(); ?>"<?php endif ?>
>

<?php $this->beginBody() ?>
<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_after_body_start.phtml') ?>

<?= $this->render('html/header.phtml'); ?>
<?php if (method_exists($this->context, 'renderHeaderBottom')): ?>
<?= $this->context->renderHeaderBottom(); ?>
<?php endif; ?>
<?= $this->render('html/_breadcrumbs.phtml'); ?>
<?= $this->render('html/_message.phtml'); ?>
<?= $content ?>
<?= $this->render('html/footer.phtml'); ?>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>

<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_before_body_end.phtml') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
