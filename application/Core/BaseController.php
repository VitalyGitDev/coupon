<?php
namespace Application\Core;

abstract class BaseController
{
    /**
     * @var View  $view View instance which will render html template for response.
     */
    public $view;

    /**
     * @var ServiceLocator $services Services provided by system ServiceLocator.
     */
    protected $services;

    /**
     * Constructor for base controller instance.
     *
     * BaseController constructor.
     * @param ServiceLocator $services
     */
    public function __construct(ServiceLocator $services)
    {
        $this->view = new View();
        $this->services = $services;
    }

}
