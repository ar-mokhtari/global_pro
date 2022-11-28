<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <li class="nav-item dashboard" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Dashboard') ?>">
        <a class="nav-link" href="<?= tools()->getUrl('admin/dashboard') ?>">
            <i class="fas fa-fw fa-cash-register"></i>
            <span class="nav-link-text"><?= __('admin', 'Dashboard') ?></span>
        </a>
    </li>
    <li><a class="js-pjax" href=""
           data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/letters/draft']) ?>"><i
                    class="fa fa-circle-o"></i>پیش‌نویس نامه</a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-circle-o text-aqua"></i>صندوق
            <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/recieveletter']) ?>"><i
                            class="fa fa-circle-o"></i>صندوق دریافتی</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/sendletters']) ?>"><i
                            class="fa fa-circle-o"></i>نامه های ارسالی </a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-circle-o text-aqua"></i>نامه‌های ارجاعی
            <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/inreferralletters']) ?>"><i
                            class="fa fa-circle-o"></i>ارجاعی گرفته شده</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/outreferralletters']) ?>"><i
                            class="fa fa-circle-o"></i>ارجاعی فرستاده شده</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-circle-o text-aqua"></i>گزارش نامه‌ها
            <span class="pull-left-container">
                  <i class="fa fa-angle-right pull-left"></i>
                </span>
        </a>
        <ul class="treeview-menu">
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/letterstrash']) ?>"><i
                            class="fa fa-circle-o"></i>نامه های حذف شده</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/readedletters']) ?>"><i
                            class="fa fa-circle-o"></i>نامه های خوانده  شده</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/unreadedletters']) ?>"><i
                            class="fa fa-circle-o"></i>نامه های خوانده نشده</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/securityletters']) ?>"><i
                            class="fa fa-circle-o"></i>  نامه های محرمانه</a></li>
            <li><a class="js-pjax"
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/reports/forceletters']) ?>"><i
                            class="fa fa-circle-o"></i>نامه های فوری</a></li>
        </ul>
    </li>
    <li><a class="js-pjax"
           data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/users/index']) ?>"><i
                    class="fa fa-circle-o"></i>کاربران</a></li>
    <li class="nav-item orders" data-toggle="tooltip" data-placement="bottom" title="<?= __('centraloffice', 'List of software') ?>">
        <a class="nav-link  nav-link-collapse collapsed"  data-toggle="collapse" href="#collapseOrder" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text"><?= __('centraloffice', 'OfficeCenter') ?></span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseOrder">
            <li class="nav-item dashboard" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Dashboard') ?>">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-cash-register"></i>
                    <span class="nav-link-text"><?= __('admin', 'Dashboard') ?></span>
                </a>
            </li>
            <li><a class="js-pjax" href=""
                   data-href="<?= Yii::$app->urlManager->createUrl(['officeautomation/letters/draft']) ?>"><i
                            class="fa fa-circle-o"></i>پیش‌نویس نامه</a></li>
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'Hotel')]) ?>"><?= __('admin', 'Hotel') ?></a>
            </li>
            <?php /*<li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'IntlHotel')]) ?>"><?= __('admin', 'International Hotel') ?></a>
            </li>*/ ?>
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'Bus')]) ?>"><?= __('admin', 'Bus') ?></a>
            </li>
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'Insurance')]) ?>"><?= __('admin', 'Insurance') ?></a>
            </li>
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'Tourism')]) ?>"><?= __('admin', 'Tourism') ?></a>
            </li>
        </ul>
    </li>
    <?php if (tools()->isAdmin()): ?>
    <?php endif ?>
    <?php if (tools()->isSuperAdmin()): ?>
    <?php endif ?>
</ul>
<ul class="navbar-nav sidenav-toggler">
    <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </li>
</ul>
<?php
require 'modals/modal_box.html';
$script = <<<JS
$(document).on('click','.js-pjax',function(e) {
        NProgress.start();
        var link = $(this).data('href');
        var link_ajax = link;
        var ok = true;
        $.post(link_ajax,{ok:ok},function(data) {
            $('#layout-render').html(data);
            history.pushState(null,'',link);
             NProgress.done();
        });
}).on('click','.js-pjax',function(e) {
    e.preventDefault();
});
$(document).on('click','.js-pjax-modal',function(e) {
        NProgress.start();
        var link_ajax = $(this).data('href');
        var ok = true;
        $.post(link_ajax,{ok:ok},function(data) {
            $('#modal_box').modal('show').find('#modal_box_body').html(data);
            $('.modal-header').find('.modal-title').text('سند حسابداری');
            NProgress.done();
        });
}).on('click','.js-pjax-modal',function(e) {
    e.preventDefault();
});

JS;
$this->registerJs($script);
?>
