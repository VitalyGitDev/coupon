<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 0:35
 */
namespace Application\Services;

use Application\Core\Service;
use Illuminate\Database\Capsule\Manager as Capsule;

class DbStorage extends Service
{
    /**
     * DbStorage constructor.
     * Initiates connection to DB using EloquentORM Capsule.
     *
     * @param string $dbConfigPath Database configurations.
     * @throws \Exception
     */
    public function __construct(string $dbConfigPath)
    {
        $dbConfig = (! empty($dbConfigPath)) ? require_once($dbConfigPath) : null;

        if (! empty($dbConfig)) {
            $capsule = new Capsule;
            $capsule->addConnection($dbConfig);
            //Make this Capsule instance available globally.
            $capsule->setAsGlobal();
            // Setup the Eloquent ORM.
            $capsule->bootEloquent();
        } else
            throw new \Exception("Error Processing database config file path.", 1);

    }

}