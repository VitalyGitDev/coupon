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

class Vouchers implements MigrationInterface
{

    /**
     * @inheritdoc.
     */
    public function run()
    {
        Capsule::schema()->create('vouchers', function ($table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('program_id')->unsigned();
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->string('partner_voucher_id')->unique();
            $table->dateTime('start_date');
            $table->dateTime('expiry_date');
            $table->string('discount')->default(0);
            $table->string('description')->nullable(true);
            $table->string('destination_url');
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('set null');
            $table->string('commission_value_formatted');
            $table->float('commission_value')->default(0);
            $table->dateTime('checked_at')->nullable(true);
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