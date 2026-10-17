<?php declare(strict_types=1);

use Nip\View\View;

/** @var View $this */
$record = $this->item ?? $this->model ?? null;
$recordId = $record && isset($record->id) ? (int)$record->id : 0;
?><?= $this->load('/abstract/view'); ?>
<?php if ($recordId > 0) : ?>
    <div class="mt-3">
        <form method="get" action="">
            <input type="hidden" name="id" value="<?= $recordId ?>">
            <button type="submit" name="action" value="editor" class="btn btn-primary">Edit PDF layout</button>
        </form>
    </div>
<?php endif; ?>
