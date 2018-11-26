<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 21:02
 */

use Application\Models\CurrencyModel;
use Application\Models\ProgramModel;

return [
    'coupon' => [
        "code" => "code",
        "programId" => [
            "class" => ProgramModel::class,
            "identify_by" => "partner_program_id",
            "map_to" => "program_id",
            "additional_args" => [
                //'newName' => 'oldName in inbound entity'
                'name' => 'program_name'
            ]
        ],
        "startDate" => "start_date",
        "expiryDate" => "expiry_date",
        "description" => "description",
        "destinationUrl" => "destination_url",
        "discount" => "discount",
        "currency" => [
            "class" => CurrencyModel::class,
            "identify_by" => "name",
            "map_to" => "currency_id"
        ],
        "id" => "partner_voucher_id",
        "commissionValueFormatted" => "commission_value_formatted",
        "commissionValue" => "commission_value",
    ]
];