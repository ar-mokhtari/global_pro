<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= __('admin', 'Ready to Leave?') ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
            </div>
            <div class="modal-body"><?= __('admin', 'Select "Logout" below if you are ready to end your current session.') ?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __('admin', 'Cancel') ?></button>
                <a class="btn btn-primary" href="<?= tools()->getUrl('user/logout') ?>"><?= __('admin', 'Logout') ?></a>
            </div>
        </div>
    </div>
</div>
