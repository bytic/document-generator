
<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?php echo ConfirmationLetters::instance()->getLabel('upload'); ?>
        </h4>
    </div>

    <div class="card-body">
        <?= $this->load('../item/upload'); ?>
    </div>
</div>