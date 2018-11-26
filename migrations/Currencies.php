<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 1:45
 */
namespace Migrations;

use Application\Core\Interfaces\MigrationInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class Currencies implements MigrationInterface
{

    /**
     * @inheritdoc
     */
    public function run()
    {
        Capsule::schema()->create('currencies', function ($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    /**
     * @inheritdoc
     */
    public function rollback()
    {

    }
}