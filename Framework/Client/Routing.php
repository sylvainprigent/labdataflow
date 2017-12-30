<?php
namespace Mumux\client;

abstract class Routing
{

    protected $identifier;
    protected $path;
    protected $component;
    protected $layout;
    protected $restricted;

    public abstract function listRouts();

    /**
     * Add one route
     * 
     * @param string $identifier Route identifier
     * @param string $path Route URL
     * @param string $component Component name (html file)
     * @param string $layout Layout path
     * @param string $restricted true if the component is restricted
     * 
     */
    public function addRoute($identifier, $path, $component, $layout, $restricted)
    {
        $this->identifier[] = $identifier;
        $this->path[] = $path;
        $this->component[] = $component;
        $this->layout[] = $layout;
        $this->restricted[] = $restricted;
    }

    public function count()
    {
        return count($this->identifier);
    }

    public function getIdentifier($i)
    {
        return $this->identifier[$i];
    }

    public function getPath($i)
    {
        return $this->path[$i];
    }

    public function getComponent($i)
    {
        return $this->component[$i];
    }

    public function getLayout($i)
    {
        return $this->layout[$i];
    }

    public function getRestricted($i)
    {
        return $this->restricted[$i];
    }

}