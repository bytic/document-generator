<?php

namespace ByTIC\DocumentGenerator\Bundle\Frontend\Controllers;

use ByTIC\DocumentGenerator\Utility\ViewUtility;
use Nip\View\View;

trait AbstractControllerTrait
{
    use \Nip\Controllers\Traits\AbstractControllerTrait;

    public function registerViewPaths(View $view): void
    {
        parent::registerViewPaths($view);

        ViewUtility::registerViewPaths($view, 'frontend');
    }
}
