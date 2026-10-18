<form action="<?php echo \ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels::letters()->getUploadURL(); ?>" method="post" enctype="multipart/form-data" style="margin-bottom: 15px">
    <input type="hidden" name="type" value="<?= htmlspecialchars((string) $this->_type, ENT_QUOTES, 'UTF-8'); ?>"/>
    <input type="hidden" name="id_item" value="<?= htmlspecialchars((string) $this->_parent->id, ENT_QUOTES, 'UTF-8'); ?>"/>
        
    <div class="form-group">
        <input type="file" name="letter" />
    </div>
    <button type="submit" class="btn btn-sm btn-primary" >Upload files</button>    
</form>