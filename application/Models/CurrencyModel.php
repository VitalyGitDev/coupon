<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 21:15
 */
namespace Application\Models;

use Application\Core\Model;

class CurrencyModel extends Model
{
    /**
     * @inheritdoc.
     */
    protected $table = "currencies";

    /**
     * @inheritdoc.
     */
    protected $fillable = [
        'name'
    ];

}
