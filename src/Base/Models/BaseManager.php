<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Base\Models;

use ByTIC\DocumentGenerator\Utility\PackageConfig;
use Nip\Records\RecordManager;

abstract class BaseManager extends RecordManager
{
    public function generateTable(): string
    {
        $key = $this->getTableKey();
        $default = $this->defaultTableName();

        return PackageConfig::tableName($key, $default) ?? $default;
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
