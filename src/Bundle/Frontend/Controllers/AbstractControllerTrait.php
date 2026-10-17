<?php

namespace ByTIC\DocumentGenerator\Bundle\Frontend\Controllers;

use ByTIC\DocumentGenerator\Utility\ViewUtility;
use Nip\View\View;

trait AbstractControllerTrait
{
    use \Nip\Controllers\Traits\AbstractControllerTrait;

    /**
     * Consuming controllers must inherit a parent controller that defines registerViewPaths.
     */
    public function registerViewPaths(View $view): void
    {
        parent::registerViewPaths($view);

        ViewUtility::registerViewPaths($view, 'frontend');
    }
}
