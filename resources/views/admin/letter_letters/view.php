<?php

declare(strict_types=1);

use \Nip\View\View;

/** @var View $this */
$record = $this->item ?? $this->model ?? null;
$recordId = $record && isset($record->id) ? (int)$record->id : 0;
?>
<?= $this->Flash()->render($this->controller); ?>

<div class="row">
    <div class="col-sm-5">
        <?= $this->load('/letter_letters/modules/panels/item-details'); ?>
        <?= $this->load('/letter_letters/modules/panels/item-form'); ?>
        <?= $this->load('/letter_letters/modules/panels/item-upload'); ?>
    </div>
    <div class="col-sm-7">
        <?= $this->load('/letter_letters/modules/panels/item-fields'); ?>
    </div>
</div>
