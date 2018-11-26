<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 1:20
 */

ini_set('display_errors',1);
ini_set('register_globals',0);
ini_set('error_reporting',E_ALL);

require_once(__DIR__ . '/../vendor/autoload.php');

use Application\Core\ServiceLocator;

$servicesList = require_once(__DIR__ . '/../application/config/services.php');
$services = new ServiceLocator($servicesList);
// Initiates DB connection.
$services->get('dbStorage');

$migrations = [
    'Programs' => 'Migrations\\Programs',
    'Currencies' => 'Migrations\\Currencies',
    'Vouchers' => 'Migrations\\Vouchers',
];

try {
    foreach ($migrations as $migrationName => $migrationClass) {
        echo "Migrating " . $migrationName . " . . . \r\n";
        /** Migration processing. */
        (new $migrationClass)->run();
    }
    echo "Migrated successfully! \r\n";
} catch (\Exception $e) {
    echo "An Error occurs during migration: ";
    die($e->getMessage());
}

