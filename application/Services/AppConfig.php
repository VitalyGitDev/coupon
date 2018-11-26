<?php
namespace Application\Services;

use Application\Core\Service;

class AppConfig extends Service
{
    /** @var array $config Application configurations. */
    protected $config = [];

    /**
     * AppConfig service constructor.
     *
     * @param string $globalsConfigPath
     * @param string $routesConfigPath
     * @throws \Exception
     */
    public function __construct(string $globalsConfigPath, string $routesConfigPath)
    {
        $globals = (! empty($globalsConfigPath)) ? require_once($globalsConfigPath) : null;
        $routes = (! empty($routesConfigPath)) ? require_once($routesConfigPath) : null;

        if (! empty($globals))
            $this->config = array_merge($this->config, $globals);
        else
            throw new \Exception("Error Processing Request for globalsConfig file path.", 1);

        if (! empty($routes))
            $this->config = array_merge($this->config, $routes);
        else
            throw new \Exception("Error Processing Request for routesConfig file path.", 1);
    }

    /**
     * Returns configurations data by key.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (!empty($this->config[$key])) {
            return $this->config[$key];
        } else {
            return null;
        }
    }

    /**
     * Returns all application configurations.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->config;
    }
}
