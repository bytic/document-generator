<?php

use Nip\Cache\Stores\Repository;
use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Inflector\Inflector;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Nip\Container\Container();
$container->set('config', new Config());
$container->set('inflector', new Inflector());

$cachePath = TEST_FIXTURE_PATH.'/storage/cache';
array_map(function ($path) {
    if (is_file($path)) {
        unlink($path);
    }
}, glob($cachePath.'/@/*'));

$adapter = new FilesystemAdapter('', 600, $cachePath);
$store = new Repository($adapter);
$store->clear();
$container->set('cache.store', $store);

Container::setInstance($container);
