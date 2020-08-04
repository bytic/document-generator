<?php

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'fixtures');

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Nip\Container\Container();
$container->set('config', new \Nip\Config\Config());
$container->set('inflector', new \Nip\Inflector\Inflector());

\Nip\Container\Container::setInstance($container);
