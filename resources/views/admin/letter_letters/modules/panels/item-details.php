<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <?= \ByTIC\Icons\Icons::list_ul(); ?>
            <?php echo \ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels::letters()->getLabel('title'); ?>
        </h4>
    </div>

    <?= $this->load('../item/details'); ?>
</div>