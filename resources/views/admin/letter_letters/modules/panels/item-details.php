<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?= \ByTIC\Icons\Icons::list_ul(); ?>
            <?php echo \ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels::letters()->getLabel('title'); ?>
        </h4>
    </div>

    <?= $this->load('../item/details'); ?>
</div>