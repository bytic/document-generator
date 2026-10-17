<?php
/** @var string $title */
/** @var array $payload */
/** @var string $saveUrl */
/** @var string $dataUrl */
/** @var string $css */
/** @var string $js */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8') ?></title>
    <style><?= $css ?></style>
</head>
<body>
<div
    class="dg-pdf-editor"
    data-save-url="<?= htmlspecialchars((string)$saveUrl, ENT_QUOTES, 'UTF-8') ?>"
    data-data-url="<?= htmlspecialchars((string)$dataUrl, ENT_QUOTES, 'UTF-8') ?>"
>
    <script type="application/json" class="dg-pdf-editor__payload"><?= json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
    <aside class="dg-pdf-editor__sidebar">
        <div class="dg-pdf-editor__sidebar-header">
            <h1><?= htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8') ?></h1>
            <button type="button" class="dg-pdf-editor__save">Save layout</button>
        </div>
        <div class="dg-pdf-editor__pages-nav"></div>
        <div class="dg-pdf-editor__fields-palette"></div>
        <div class="dg-pdf-editor__properties">
            <h2>Field properties</h2>
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
                </div>
            </form>
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
</div>
<script><?= $js ?></script>
</body>
</html>
