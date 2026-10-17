<?php

namespace ByTIC\DocumentGenerator\Utility;

class PathsHelpers
{
    public static function basePath(): string
    {
        return dirname(__DIR__, 2);
    }

    public static function config(?string $path = null): string
    {
        return static::basePath() . '/config' . ($path ?? '');
    }

    public static function resources(?string $path = null): string
    {
        return static::basePath() . '/resources' . ($path ?? '');
    }

    public static function assets(?string $path = null): string
    {
        return static::resources() . '/assets' . ($path ?? '');
    }

    public static function views(?string $path = null): string
    {
        return static::resources() . '/views' . ($path ?? '');
    }

    public static function migrations(?string $path = null): string
    {
        return static::basePath() . '/migrations' . ($path ?? '');
    }
}
