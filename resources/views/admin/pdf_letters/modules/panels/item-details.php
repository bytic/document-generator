<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?= \ByTIC\Icons\Icons::list_ul(); ?>
            <?php echo ConfirmationLetters::instance()->getLabel('title'); ?>
        </h4>
    </div>

    <?= $this->load('../item/details'); ?>
</div>