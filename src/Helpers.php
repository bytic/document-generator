<?php

namespace ByTIC\DocumentGenerator;

/**
 * Class Helpers
 * @package ByTIC\DocumentGenerator
 */
class Helpers
{
    /**
     * @return string
     */
    public static function author()
    {
        if (!function_exists('app') or !app()->has('config')) {
            return 'bytic';
        }

        return app('config')->get('SITE.name');
    }
}
