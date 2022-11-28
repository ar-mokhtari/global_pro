<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a class="nav-link" href="<?= tools()->getBaseUrl() ?>">
            <i class="fa fa-globe mr-1"></i><?= __('admin', 'View Site') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= tools()->getUrl('account') ?>">
            <i class="fa fa-user-circle mr-1"></i><?= __('admin', 'My Account') ?>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-sign-out-alt mr-1"></i><?= __('admin', 'Logout') ?>
        </a>
    </li>
</ul>