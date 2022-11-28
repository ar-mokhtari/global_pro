<?php /* @var $content string */ ?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?= tools()->getUrl('admin/dashboard') ?>">
        <i class="fas fa-chart-pie mr-2 ml-2"></i><?= __('admin', 'Control Panel') ?>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <?= $this->render('navigation/top.php'); ?>
        <?= $this->render('navigation/side.php'); ?>
    </div>
</nav>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <?php \yii\widgets\Pjax::begin(['id' => 'layout-render', 'timeout' => false, 'formSelector' => false]); ?>
            <?= $content ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
