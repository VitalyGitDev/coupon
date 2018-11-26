<?php
namespace Application\Core;

use Application\Core\Interfaces\ResourseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class ResourceController implements ResourseInterface
{

    /**
     * @var Model $modelClass Full model className with namespace.
     */
    protected $modelClass;

    /**
     * @var ServiceLocator  $services Services provided by ServiceLocator.
     */
    protected $services;

    /**
     * Base constructor for resource controller.
     *
     * ResourceController constructor.
     * @param ServiceLocator $services
     */
    public function __construct(ServiceLocator $services)
    {
        $this->services = $services;
    }

    /**
     * Returns all instances for current mode.
     * Should be used as default action for GET method REST request without item_id specified.
     *
     * @return mixed|JsonResponse
     * @throws \Exception
     */
    public function index() : JsonResponse
    {
        if (!empty($this->modelClass)) return new JsonResponse($this->modelClass::all(), 200);
        else throw new \Exception("No model class found!");
    }

    /**
     * Returns existed current model instance from Database.
     * Should be used as default action for GET method REST request with item_id specified.
     *
     * @param int $id
     * @return mixed|void
     */
    public function get($id) : JsonResponse
    {

    }

    /**
     * Creates new entity in the DB.
     * Should be used as default action for POST method REST request.
     *
     * @return mixed|void
     */
    public function create() : JsonResponse
    {

    }

    /**
     * Makes update for existing entity.
     * Should be used as default action for PUT/PATCH methods REST request.
     *
     * @param $id
     * @return mixed|void
     */
    public function update($id) : JsonResponse
    {

    }

    /**
     * Removes entity from Database.
     * Should be used as default action for DELETE methods REST request.
     *
     * @param $id
     * @return JsonResponse
     */
    public function remove($id) : JsonResponse
    {

    }
}
