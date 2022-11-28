<?php

/* @var $this \yii\web\View */
/* @var $content string */

// use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
?>
<?php
if (!isset($this->params['breadcrumbs'])) {
    return;
}
$links = $this->params['breadcrumbs'];
if (!isset($links[0])) {
    $links[0] = [
        'label' => __('admin', 'Control Panel'),
        'url' => tools()->getUrl('admin/dashboard', [], false),
    ];
}
if (isset($links[10])) {
    $links[10] = [
        'label' => $links[10],
        'template' => "<li class=\"breadcrumb-item active\">{link}</li>\n",
    ];
}
ksort($links);
?>

<?= Breadcrumbs::widget([
    'itemTemplate' => "<li class=\"breadcrumb-item\">{link}</li>\n",
    'homeLink'=>false,
    'links' => $links,
]);
?>
<?php /*<script type="text/javascript">
    $(document).ready(function () {
        window.onscroll = function() {
            stickyBreadcrumbs();
        };
        var breadcrumbs = $("ul.breadcrumb");
        var sticky = breadcrumbs.offset().top;
        stickyBreadcrumbs();
        function stickyBreadcrumbs() {
            window.pageYOffset >= sticky - 56 
                ? breadcrumbs.addClass("sticky-nov sticky-breadcrumbs")
                : breadcrumbs.removeClass("sticky-nov sticky-breadcrumbs");
        }
    });
</script>*/ ?>
