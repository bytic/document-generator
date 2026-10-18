<?php
declare(strict_types=1);
/** @var string $title */
/** @var array $payload */
/** @var string $saveUrl */
/** @var string $dataUrl */
/** @var string $downloadDemoUrl */

use ByTIC\DocumentGenerator\Utility\ViewUtility;

$this->Stylesheets()->addRaw(ViewUtility::loadAssetContent('/scss/letter-editor.css'));
$this->Scripts()->addRaw(ViewUtility::loadAssetContent('/js/letter-editor.js'));
$downloadDemoUrl = $downloadDemoUrl ?? '';
?>
<div
    class="dg-pdf-editor"
    data-save-url="<?= htmlspecialchars((string)$saveUrl, ENT_QUOTES, 'UTF-8') ?>"
    data-data-url="<?= htmlspecialchars((string)$dataUrl, ENT_QUOTES, 'UTF-8') ?>"
>
    <script type="application/json" class="dg-pdf-editor__payload"><?= json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
    <aside class="dg-pdf-editor__sidebar">
        <div class="dg-pdf-editor__sidebar-header">
            <h1><?= htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8') ?></h1>
            <div class="dg-pdf-editor__header-actions">
                <form action="<?= htmlspecialchars((string)$downloadDemoUrl, ENT_QUOTES, 'UTF-8') ?>" method="post">
                    <button type="submit" class="dg-pdf-editor__download-demo">Download DEMO</button>
                </form>
                <button type="button" class="dg-pdf-editor__save">Save layout</button>
            </div>
        </div>
        <div class="dg-pdf-editor__pages-nav"></div>
        <div class="dg-pdf-editor__fields-palette"></div>
        <div class="dg-pdf-editor__properties">
            <h2>Field editing</h2>
            <p>Use each field's <strong>Edit</strong> button on the page to update its properties.</p>
        </div>
    </aside>
    <main class="dg-pdf-editor__workspace">
        <div class="dg-pdf-editor__pages">
            <?php foreach (($payload['pages'] ?? []) as $page) : ?>
                <?php
                $width = isset($page['width']) && (float)$page['width'] > 0 ? (float)$page['width'] : 1;
                $height = isset($page['height']) ? (float)$page['height'] : 1;
                ?>
                <section
                    class="dg-pdf-editor__page"
                    data-page="<?= (int)$page['number'] ?>"
                    style="width: 900px; height: <?= (($height / $width) * 900) ?>px;"
                >
                    <iframe src="<?= htmlspecialchars(($payload['pdfSource'] ?? '') . '#page=' . (int)$page['number'] . '&toolbar=0&navpanes=0&scrollbar=0', ENT_QUOTES, 'UTF-8') ?>"></iframe>
                    <div class="dg-pdf-editor__overlay"></div>
                </section>
            <?php endforeach; ?>
        </div>
    </main>

    <div class="dg-pdf-editor__modal" hidden>
        <div class="dg-pdf-editor__modal-backdrop"></div>
        <div class="dg-pdf-editor__modal-dialog" role="dialog" aria-modal="true" aria-label="Edit field">
            <div class="dg-pdf-editor__modal-header">
                <h2>Edit field</h2>
                <button type="button" class="dg-pdf-editor__modal-close" aria-label="Close">×</button>
            </div>
            <form class="dg-pdf-editor__form">
                <label><span>Field</span><input type="text" name="field" readonly></label>
                <label><span>Page</span><input type="number" min="1" name="page"></label>
                <label><span>X</span><input type="number" step="0.01" name="x"></label>
                <label><span>Y</span><input type="number" step="0.01" name="y"></label>
                <label><span>Size</span><input type="number" min="1" name="size"></label>
                <label><span>Align</span>
                    <select name="align">
                        <option value="left">Left</option>
                        <option value="center">Center</option>
                        <option value="right">Right</option>
                    </select>
                </label>
                <label><span>Color</span><input type="color" name="color"></label>
                <label><span>Transform</span><input type="text" name="textTransform"></label>
                <div class="dg-pdf-editor__form-actions">
                    <button type="button" class="dg-pdf-editor__remove">Remove field</button>
                    <button type="button" class="dg-pdf-editor__modal-close">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>
