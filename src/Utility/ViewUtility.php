<?php

namespace ByTIC\DocumentGenerator\Utility;

use Nip\View\View;

/**
 * Utility helpers for managing module-specific view paths and asset content.
 */
class ViewUtility
{
    public const NAME = 'DocumentGenerator';
    /**
     * @param $path
     *
     * @return string
     */
    public static function loadAssetContent($path)
    {
        $fullPath = PathsHelpers::assets($path);
        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }

        return '';
    }

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
