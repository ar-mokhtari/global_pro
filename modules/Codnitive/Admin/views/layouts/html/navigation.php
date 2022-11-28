<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?= tools()->getUrl('account') ?>">
        <i class="fas fa-chart-pie mr-2 ml-2"></i><?= __('admin', 'Control Panel') ?>
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <?= $this->render('navigation/side.php'); ?>
        <?= $this->render('navigation/top.php'); ?>
    </div>
</nav>
