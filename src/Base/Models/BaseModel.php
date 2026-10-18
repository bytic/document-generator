<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Base\Models;

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Records\Record;

abstract class BaseModel extends Record
{
    protected static function tableNameKey(): string
    {
        $class = static::class;

        return strtolower((new \ReflectionClass($class))->getShortName());
    }

    public static function tableName(): string
    {
        $key = static::tableNameKey();
        $default = static::defaultTableName();

        return PackageConfig::tableName($key, $default) ?? $default;
    }

    protected static function defaultTableName(): string
    {
        $class = static::class;

        return strtolower((new \ReflectionClass($class))->getShortName());
    }

    public function generateTable(): string
    {
        return static::tableName();
    }
}
