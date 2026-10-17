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
        $path = false;
        if ($module !== null && $module !== '') {
            $modulePath = PathsHelpers::views('/' . $module);
            if (is_dir($modulePath)) {
                $path = realpath($modulePath);
            }
        }
        if (!$path) {
            $path = realpath(PathsHelpers::views());
        }
        if (!$path) {
            return;
        }

        $view->addPath($path);
        $view->addPath($path, self::NAME);
    }
}
