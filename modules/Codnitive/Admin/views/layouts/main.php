<?php

/* @var $this \yii\web\View */
/* @var $content string */

// use yii\helpers\Html;
// use app\modules\Codnitive\Template\assets\Main;
// Main::register($this);

// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Admin\assets\Panel;
// Panel::register($this);

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Admin', 'Panel');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html <?php if (!empty($block->getLanguage())): ?>lang="<?= $block->getLanguage() ?>"<?php endif ?>>
<head>
    <?= $this->render('html/_after_head_start.phtml') ?>
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
    <?= $this->render('html/_before_head_end.phtml') ?>
</head>
<body 
    <?php if (!empty($this->context->getBodyId())): ?>id="<?= $this->context->getBodyId(); ?>"<?php endif ?> 
    <?php if (!empty($this->context->getBodyClass())): ?>class="<?= $this->context->getBodyClass(); ?>"<?php endif ?>
>
<?php $this->beginBody() ?>
<?= $this->render('html/_after_body_start.phtml') ?>

<?= $this->render('html/navigation.php'); ?>

<div class="content-wrapper">
    <div class="container-fluid" id="content">
        <?= $this->render('html/breadcrumbs.php'); ?>
        <?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_message.phtml'); ?>
        <div class="main">
            <?= $content ?>
        </div>
    </div>
</div>

<?= $this->render('html/footer.php'); ?>

<?php if (app()->language == 'fa-IR'): ?>
<?php $block->registerAssets($this, 'Template', 'JqueryValidateFa') ?>
<?php endif; ?>
<?php $block->registerAssets($this, 'Template', 'CustomJS'); ?>

<?= $this->render('html/_before_body_end.phtml') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
