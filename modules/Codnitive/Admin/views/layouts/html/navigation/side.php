<ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
    <li class="nav-item dashboard" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Dashboard') ?>">
        <a class="nav-link" href="<?= tools()->getUrl('admin/dashboard') ?>">
            <i class="fas fa-fw fa-cash-register"></i>
            <span class="nav-link-text"><?= __('admin', 'Dashboard') ?></span>
        </a>
    </li>
    <li class="nav-item orders" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Oreders') ?>">
        <a class="nav-link  nav-link-collapse collapsed"  data-toggle="collapse" href="#collapseOrder" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text"><?= __('admin', 'Oreders') ?></span>
        </a>
        <ul class="sidenav-second-level collapse" id="collapseOrder">
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'IntlFlight')]) ?>"><?= __('admin', 'International Flight') ?></a>
            </li>
            <li>
                <a href="<?= tools()->getUrl('admin/orders', ['Filter[ticket_type]' => __('admin', 'DomcFlight')]) ?>"><?= __('admin', 'Domestic Flight') ?></a>
            </li>
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
        <li class="nav-item refund-requests" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Refund Requests') ?>">
            <a class="nav-link" href="<?= tools()->getUrl('admin/refunds/index') ?>">
                <i class="fas fa-fw fa-comment-dollar"></i>
                <span class="nav-link-text"><?= __('admin', 'Refund Requests') ?></span>
            </a>
        </li>
        <li class="nav-item price-rules" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Price Rules') ?>">
            <a class="nav-link" href="<?= tools()->getUrl('admin/pricerule/index') ?>">
                <i class="fas fa-fw fa-money-check-alt"></i>
                <span class="nav-link-text"><?= __('admin', 'Price Rules') ?></span>
            </a>
        </li>
        <li class="nav-item coupon" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Coupon') ?>">
            <a class="nav-link" href="<?= tools()->getUrl('admin/coupon/index') ?>">
                <i class="fas fa-fw fa-percent"></i>
                <span class="nav-link-text"><?= __('admin', 'Coupon') ?></span>
            </a>
        </li>
        <li class="nav-item wallet" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Wallet') ?>">
            <a class="nav-link" href="<?= tools()->getUrl('admin/wallet/edit') ?>">
                <i class="fas fa-wallet"></i>
                <span class="nav-link-text"><?= __('admin', 'Wallet') ?></span>
            </a>
        </li>
    <?php endif ?>
    <?php if (tools()->isSuperAdmin()): ?>
        <li class="nav-item parto-data-importer" data-toggle="tooltip" data-placement="bottom" title="<?= __('admin', 'Parto Hotel Data Importer') ?>">
            <a class="nav-link" href="<?= tools()->getUrl('admin/staticdata/hotelImporter') ?>">
                <i class="fas fa-fw fa-database"></i>
                <span class="nav-link-text"><?= __('admin', 'Parto Hotel Data Importer') ?></span>
            </a>
        </li>
    <?php endif ?>
</ul>
<ul class="navbar-nav sidenav-toggler">
    <li class="nav-item">
        <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
        </a>
    </li>
</ul>
