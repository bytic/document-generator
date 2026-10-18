<?php
declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;

?>
<div class="card mb-3">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <?= DocumentGeneratorModels::letters()->getLabel('upload'); ?>
        </h4>
    </div>
    <div class="card-body">
        <?= $this->Flash()->render($this->controller); ?>

        <?= $this->load('modules/item/upload'); ?>
    </div>
</div>