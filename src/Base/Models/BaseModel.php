<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Base\Models;

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Records\Record;
use Nip\Records\RecordManager;

abstract class BaseModel extends Record
{
    protected static function tableNameKey(): string
    {
        return strtolower((new \ReflectionClass(static::class))->getShortName());
    }

    public static function tableName(): string
    {
        return PackageConfig::tableName(static::tableNameKey(), static::defaultTableName());
    }

    protected static function defaultTableName(): string
    {
        return strtolower((new \ReflectionClass(static::class))->getShortName());
    }

    public function generateTable(): string
    {
        return static::tableName();
    }
}

abstract class BaseManager extends RecordManager
{
    public function generateTable(): string
    {
        return PackageConfig::tableName($this->getTableKey(), $this->defaultTableName());
    }

    protected function getTableKey(): string
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }

    protected function defaultTableName(): string
    {
        return strtolower((new \ReflectionClass($this))->getShortName());
    }
}
