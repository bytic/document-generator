<?php

namespace ByTIC\DocumentGenerator\Utility;

use Nip\View\View;

class ViewUtility
{
    public const NAME = 'DocumentGenerator';

    /**
     * Registers module-specific views when available and falls back to the base views directory.
     */
    public static function registerViewPaths(View $view, $module = null): void
    {
        if ($module !== null && $module !== '') {
            if (!preg_match('/^[a-zA-Z0-9_-]+$/', (string)$module)) {
                return;
            }
            $path = realpath(PathsHelpers::views('/' . $module));
        } else {
            $path = realpath(PathsHelpers::views());
        }
        if (!$path) {
            return;
        }

        $view->addPath($path);
        $view->addPath($path, self::NAME);
    }
}
