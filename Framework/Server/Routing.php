<?php
namespace Mumux\server;

abstract class Routing
{

    protected $identifier;
    protected $requestTypes;
    protected $paths;
    protected $routes;
    protected $actions;
    protected $gets;
    protected $getsRegexp;


    public abstract function listRouts();

    /**
     * Add one route
     * 
     * @param string $identifier Rout identifier
     * @param string $url Rout URL
     * @param string $controller Controller name
     * @param string $action Controller action
     * @param string $gets List of gets variables
     * @param string $getsRegexp List of gets variables type as regrexp
     * 
     */
    public function addRoute($identifier, $requestType, $path, $route, $action, $gets = array(), $getsRegexp = array())
    {
        $this->identifier[] = $identifier;
        $this->requestTypes[] = $requestType;
        $this->paths[] = $path;
        $this->routes[] = $route;
        $this->actions[] = $action;
        $this->gets[] = $gets;
        $this->getsRegexp[] = $getsRegexp;
    }

    public function count()
    {
        return count($this->requestTypes);
    }

    public function getIdentifier($i)
    {
        return $this->identifier[$i];
    }

    public function getRequestType($i)
    {
        return $this->requestTypes[$i];
    }

    public function getPath($i)
    {
        return $this->paths[$i];
    }

    public function getRoute($i)
    {
        return $this->routes[$i];
    }

    public function getAction($i)
    {
        return $this->actions[$i];
    }

    public function getGet($i)
    {
        return $this->gets[$i];
    }

    public function getGetRegexp($i)
    {
        return $this->getsRegexp[$i];
    }

}