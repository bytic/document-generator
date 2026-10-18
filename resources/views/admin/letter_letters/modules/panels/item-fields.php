<?php
declare(strict_types=1);

use ByTIC\DocumentGenerator\Utility\DocumentGeneratorModels;

$fieldsRepository = DocumentGeneratorModels::letterFields();
$importLinks = $this->importLinks;
?>
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">
            <?= $fieldsRepository->getLabel('title'); ?>
        </h4>

        <div class="d-flex align-items-center gap-2">
            <?php if ($importLinks) { ?>
                <div class="btn-group">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="icon-download icon-white"></i>
                        IMPORT
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach ($importLinks as $importLink) { ?>
                            <li>
                                <a class="dropdown-item" href="<?= $importLink['href']; ?>">
                                    <?= $importLink['name']; ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <a class="btn btn-success btn-sm"
               href="<?= $fieldsRepository->compileURL('add', ['id_letter' => $this->letter->id]); ?>"
            >
                <i class="fas fa-plus-circle"></i>
                <?= $fieldsRepository->getLabel('add'); ?>
            </a>
        </div>
    </div>

    <?= $this->load('/letter_fields/modules/list-letter'); ?>


    <div class="card-footer d-flex align-items-center justify-content-between">
        <form action="<?= $this->letter->compileURL('downloadExample'); ?>" method="post" class="mb-0">
            <button class="btn btn-success btn-sm" type="submit">
                Download DEMO
            </button>
        </form>
        <a class="btn btn-outline-primary btn-sm" href="<?= $this->letter->compileURL('editor'); ?>">
            Editor
        </a>
    </div>
</div>