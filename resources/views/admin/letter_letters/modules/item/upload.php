<form action="<?php echo ConfirmationLetters::instance()->getUploadURL(); ?>" method="post" enctype="multipart/form-data" style="margin-bottom: 15px">
    <input type="hidden" name="type" value="<?= $this->_type; ?>"/>
    <input type="hidden" name="id_item" value="<?= $this->_parent->id; ?>"/>
        
    <div class="form-group">
        <input type="file" name="letter" />
    </div>
    <button type="submit" class="btn btn-sm btn-primary" >Upload files</button>    
</form>