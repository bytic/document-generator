<?php

use ByTIC\Icons\Icons;

?>
<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?= Icons::list_ul(); ?>
             <?php echo ConfirmationLetters::instance()->getLabel('upload'); ?>
        </h4>      
    </div>	
    <div class="card-body">
        <?= $this->Flash()->render($this->controller); ?>

        <?= $this->load('modules/item/upload'); ?>
    </div>
</div>