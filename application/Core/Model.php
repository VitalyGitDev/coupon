<?php
namespace Application\Core;

use Illuminate\Database\Eloquent\Model as EloquentModel;

abstract class Model extends EloquentModel {

    /**
     * All services(appConfig, dbStorage, etc.) provided by the system ServiceLocator.
     *
     * @var \Application\Core\ServiceLocator
     */
    protected $services;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
