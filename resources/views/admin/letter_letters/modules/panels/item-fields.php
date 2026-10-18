<?php
declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;

$fieldsRepository = DocumentGeneratorModels::letterFields();
$importLinks = $this->importLinks;
?>
<div class="card card-inverse">
    <div class="card-header">
        <?php if ($importLinks) { ?>
            <div class="btn-group float-end" style="margin-left: 10px">
                <a class="btn btn-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="icon-download icon-white"></i>
                    IMPORT
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php foreach ($importLinks as $importLink) { ?>
                        <li class="dropdown-item">
                            <a href="<?= $importLink['href']; ?>">
                                <?= $importLink['name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

        <a class="float-end btn btn-xs btn-success"
           href="<?= $fieldsRepository->compileURL('add', ['id_letter' => $this->letter->id]); ?>"
        >
            <i class="fas fa-plus-circle"></i>
            <?= $fieldsRepository->getLabel('add'); ?>
        </a>

        <h4 class="card-title">
            <?= $fieldsRepository->getLabel('title'); ?>
        </h4>
    </div>

    <?= $this->load('/letter_fields/modules/list-letter'); ?>


    <div class="card-footer">
        <form action="<?= $this->letter->compileURL('downloadExample'); ?>" method="post">
            <button class="btn btn-success btn-xs" type="submit">
                Download DEMO
            </button>
        </form>
    </div>
</div>