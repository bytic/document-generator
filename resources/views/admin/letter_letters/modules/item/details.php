    
<table class="details table table-striped">
	<colgroup width="35%"></colgroup>
    <tbody>
        <tr>
            <td class="name">PARENT:</td>
            <td class="value">
                <a href="<?= $this->_parent->getURL(); ?>">
                    <?= $this->_parent->getName(); ?>
                </a>
            </td>
        </tr>
        <tr>
            <td class="name"><?= translator()->trans('type'); ?>:</td>
            <td class="value"><?= $this->item->type; ?></td>
        </tr>
        <tr>
            <td class="name"><?php echo \ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels::letters()->getLabel('title.singular'); ?>:</td>
            <td class="value">
                <a href="<?= $this->letter->getDownloadBlankURL(); ?>" class="btn btn-info">
                    Download BLANK
                </a>
            </td>
        </tr>
    </tbody>
</table>