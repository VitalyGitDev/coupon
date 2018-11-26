<?php
namespace Application\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Router
{

    /** @var array $rouutes Configured in appRouting config file. */
    protected $routes;

    /** @var ServiceLocator $services ServiceLocator instance. */
    protected $services;

    /** @var RequestContext $context Request context. */
    protected $context;

    /** @var bool $isApi Shows if API requested. */
    protected $isApi = false;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $servicesList = require_once(__DIR__ . '/../config/services.php');
        $this->services = new ServiceLocator($servicesList);
        $this->context = new RequestContext();
        $this->routes = $this->services->get('appConfig')->get('default_routes');
        $this->apiRoutes = $this->services->get('appConfig')->get('api_routes');
    }

    /**
     * Starts request processing with routing.
     */
    public function start() : void
    {
        $request = Request::createFromGlobals();
        $slug = explode('/', $request->server->get('REQUEST_URI'));
        $this->context->fromRequest($request);

        switch($slug[1]) {
            case "api" :
                $this->isApi = true;
                $this->apiRouting($request);
                break;
            default:
                $this->isApi = false;
                $this->defaultRouting($request);
                break;
        }
    }

    /**
     * Routing processing in case API requested.
     */
    protected function apiRouting(Request $request)
    {
        try {
            $response = $this->processRequest($request);
        } catch (ResourceNotFoundException $e) {
            $response = new JsonResponse(['message' => 'Not Found! ' . $e->getMessage()], 404);
        } catch (\Exception $e) {
            $response = new JsonResponse(['message' => 'An error occurs: ' . $e->getMessage()], 500);
        }

        $response->send();
    }

    /**
     * Routing processing in case usual request received.
     */
    protected function defaultRouting(Request $request)
    {
        try {
            $response = $this->processRequest($request);
        } catch (ResourceNotFoundException $e) {
            $response = new Response("<h1>Requested Page Not Found!</h1> <br />" . $e->getMessage(), 404);
        } catch (\Exception $e) {
            $response = new Response("<h1>An error occurs:</h1> <br />" . $e->getMessage(), 500);
        }

        $response->send();
    }

    /**
     * Processes request and call configured Controller action for current request.
     *
     * @param Request $request
     * @return mixed
     */
    protected function processRequest(Request $request)
    {
        $routes = ($this->isApi) ? $this->apiRoutes : $this->routes;
        $matcher = new UrlMatcher($routes, $this->context);
        $params = $matcher->match($request->getPathInfo());
        $controllerAction = explode('::', $params['_controller']);
        $controllerClass = $controllerAction[0];
        $action = $controllerAction[1];

        return (new $controllerClass($this->services))->$action($params);
    }
}
