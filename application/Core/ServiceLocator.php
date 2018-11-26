<?php
namespace Application\Core;

//TODO: Make it as Singleton!
class ServiceLocator
{
    /** @var array $services Configurations list for needed services.  */
    protected $services = [];

    /** @var array $container List of initiated service instances. */
    protected $container = [];

    /**
     * ServiceLocator class constructor.
     *
     * ServiceLocator constructor.
     * @param array $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
        $this->initiateServices();
    }


    /**
     * Returns initiated Service instance.
     *
     * @param $alias
     * @return Service
     */
    public function get($alias) : Service
    {
        if (empty($this->container[$alias])) $this->register($alias);

        return $this->container[$alias];
    }

    /**
     * Initiate Service if its necessary(requested).
     *
     * @param $alias
     */
    private function register($alias)
    {
        try {
            $className = $this->services[$alias]['class'];
            $args = $this->services[$alias]['args'];
            $this->container[$alias] = new $className(...$args);
        } catch (\Exception $e) {
            echo 'We got Exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * Checks and initiate Services which were configured with instant_load flag.
     */
    protected function initiateServices()
    {
        foreach($this->services as $serviceAlias => $service) {
            if (!empty($service['instant_load']) && $service['instant_load'])
                $this->register($serviceAlias);
        }
    }
}
