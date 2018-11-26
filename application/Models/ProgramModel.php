<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 21:22
 */
namespace Application\Models;

use Application\Core\Model;

class ProgramModel extends Model
{
    /**
     * @inheritdoc.
     */
    protected $table = "programs";

    /**
     * @inheritdoc.
     */
    protected $fillable = [
        'name', 'partner_program_id'
    ];

}