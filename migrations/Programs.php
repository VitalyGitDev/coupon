<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 1:31
 */
namespace Migrations;

use Application\Core\Interfaces\MigrationInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class Programs implements MigrationInterface
{

    /**
     * @inheritdoc.
     */
    public function run()
    {
        Capsule::schema()->create('programs', function ($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('partner_program_id');
            $table->timestamps();
        });
    }

    /**
     * @inheritdoc.
     */
    public function rollback()
    {

    }
}