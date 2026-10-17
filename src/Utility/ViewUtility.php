<?php

namespace ByTIC\DocumentGenerator\Utility;

class ViewUtility
{
    public const NAME = 'DocumentGenerator';

    /**
     * Registers module-specific views when available and falls back to the base views directory.
     */
    public static function registerViewPaths($view, $module = null): void
    {
        $path = $module ? realpath(PathsHelpers::views('/' . $module)) : false;
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
