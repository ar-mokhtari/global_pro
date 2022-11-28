<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Account', 'Panel');
$block->registerAssets($this, 'Template', 'Main');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?php if (!empty($block->getLanguage())): ?>lang="<?= $block->getLanguage() ?>"<?php endif ?>>
<head>
    <?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_after_head_start.phtml') ?>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <script type="text/javascript">var BASE_URL = '<?= tools()->getUrl('', [], false, true, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= $this->context->getMetaDescription() ?>">
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

<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/header.phtml'); ?>
<?php if (method_exists($this->context, 'renderHeaderBottom')): ?>
<?= $this->context->renderHeaderBottom(); ?>
<?php endif; ?>
<div class="super_container">
    <?php /*<?= $this->render('html/_breadcrumbs.phtml'); ?>*/ ?>
    <div class="home2"></div>
    <div class="home3">
        <div class="banner_text_inner"></div>
    </div>
    <?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_message.phtml'); ?>
    <div class="container mt-2 account-wrapper px-0">
        <div class="row mx-0">
            <?= $this->render('html/navigation.phtml', ['block' => $block]); ?>

            <div class="col-md-9 main-col content">
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/footer.phtml'); ?>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>

<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>

<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_before_body_end.phtml') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
