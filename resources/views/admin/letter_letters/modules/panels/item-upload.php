
<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <?php echo \ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels::letters()->getLabel('upload'); ?>
        </h4>
    </div>

    <div class="card-body">
        <?= $this->load('../item/upload'); ?>
    </div>
</div>