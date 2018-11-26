<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 2:07
 */

namespace Application\Core\Interfaces;


interface MigrationInterface
{
    /**
     * Method must contain eloquent migration scenario, to create/update/delete table structure.
     *
     * @return mixed
     */
    public function run();

    /**
     * Nice to have mechanism/instructions which allows to rollback all changes maded by this migration.
     *
     * @return mixed
     */
    public function rollback();
}