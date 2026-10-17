<?php

declare(strict_types=1);

namespace ByTIC\DocumentGenerator\Utility;

use ByTIC\DocumentGenerator\DocumentGeneratorProvider;
use ByTIC\PackageBase\Utility\PackageConfig as BasePackageConfig;
use Exception;

class PackageConfig extends BasePackageConfig
{
    protected $name = DocumentGeneratorProvider::NAME;

    public static function configPath(): string
    {
        return PathsHelpers::config('/document-generator.php');
    }

    public static function tableName($name, $default = null): ?string
    {
        return static::instance()->get('tables.' . $name, $default);
    }

    /**
     * @return string|null
     * @throws Exception
     */
    public static function databaseConnection(): ?string
    {
        return static::instance()->get('database.connection');
    }

    public static function shouldRunMigrations(): bool
    {
        return static::instance()->get('database.migrations', false) === true;
    }
}
