<?php

use Application\Services\AppConfig;
use Application\Services\DbStorage;
use Application\Services\DataFetcher;
use Application\Services\DataMapper;

return [
    'appConfig' => [
        'class' => AppConfig::class,
        'args' => [
            __DIR__ . '/appGlobals.php',
            __DIR__ . '/appRouting.php',
        ],
    ],
    'dbStorage' => [
        'class' => DbStorage::class,
        'args' => [
            __DIR__ . '/dbConfig.php'
        ],
        'instant_load' => true,
    ],
    'dataFetcher' => [
        'class' => DataFetcher::class,
        'args' => [
            __DIR__ . '/dataFetcher.php'
        ],
    ],
    'dataMapper' => [
        'class' => DataMapper::class,
        'args' => [
            __DIR__ . '/dataMapper.php'
        ],
    ],
];
