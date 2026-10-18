<?php
?>
<?php if (count($this->letter_fields) > 0) { ?>
    <table id="courses" class="table">
        <thead>
        <tr>
            <th><?= translator()->trans('field'); ?></th>
            <th><?= translator()->trans('position'); ?></th>
            <th><?= translator()->trans('font'); ?></th>
            <th><?= translator()->trans('color'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($this->letter_fields as $item) { ?>
            <tr>
                <td>
                    <a href="<?= $item->getURL(); ?>" title="" class="">
                        <?= $item->getName(); ?>
                    </a>
                </td>
                <td>
                    <?= $item->x; ?> :
                    <?= $item->y; ?>
                </td>
                <td>
                    <?= $item->font; ?> @
                    <?= $item->size; ?>
                </td>
                <td>
                    <?= $item->color; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <?= $this->Messages()->info($this->modelManager->getMessage('dnx')); ?>
<?php } ?>
