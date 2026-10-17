<?php

namespace ByTIC\DocumentGenerator\Utility;

class ViewUtility
{
    public const NAME = 'DocumentGenerator';

    public static function registerViewPaths($view, $module = null): void
    {
        $path = realpath($module ? PathsHelpers::views('/' . $module) : PathsHelpers::views());
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
