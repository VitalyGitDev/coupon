<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 2:21
 */

namespace Application\Core\Interfaces;


interface ResourseInterface
{

    /**
     * Should return all entities as a list.
     *
     * @return mixed
     */
    public function index();

    /**
     * Should return one entity according to specified ID parameter.
     *
     * @param int $id Index to find entity in DataBase.
     * @return mixed
     */
    public function get($id);

    /**
     * Creates new entity in database.
     *
     * @return mixed
     */
    public function create();

    /**
     * Update entity in database.
     *
     * @param $id
     * @return mixed
     */
    public function update($id);

    /**
     * remove entity from Database.
     *
     * @param $id
     * @return mixed
     */
    public function remove($id);
}