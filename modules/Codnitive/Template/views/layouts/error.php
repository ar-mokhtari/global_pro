<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\modules\Codnitive\Template\blocks\Main;
$block = new Main;
$block->registerAssets($this, 'Template', 'Error');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">var BASE_URL = '<?= tools()->getUrl('', [], false, true, true) ?>';</script>
    <meta charset="<?= app()->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="bilit.com official website, to book and buy train, airplane, hotel, flight, bus, car, event, insurance, tour, museum tickets">
    <?= tools()->csrfMetaTags() ?>
    <title><?= tools()->encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body 
    <?php if (!empty($this->context->getBodyId())): ?>id="<?= $this->context->getBodyId(); ?>"<?php endif ?> 
    <?php if (!empty($this->context->getBodyClass())): ?>class="<?= $this->context->getBodyClass(); ?>"<?php endif ?>
>

<?php $this->beginBody() ?>
<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_after_body_start.phtml') ?>

<?= $content ?>

<?= $this->render('@app/modules/Codnitive/Template/views/layouts/html/_before_body_end.phtml') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
