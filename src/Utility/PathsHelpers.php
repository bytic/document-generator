<?php

namespace ByTIC\DocumentGenerator\Utility;

class PathsHelpers
{
    public static function basePath(): string
    {
        return dirname(__DIR__, 2);
    }

    public static function resources($path = null): string
    {
        return static::basePath() . '/resources' . $path;
    }

    public static function assets($path = null): string
    {
        return static::resources() . '/assets' . $path;
    }

    public static function views($path = null): string
    {
        return static::resources() . '/views' . $path;
    }
}
