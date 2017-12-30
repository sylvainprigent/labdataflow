<?php
namespace Mumux\Server;

abstract class Route
{
    /** Action to run */
    protected $action;
    protected $module;

    /** recieved request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRepository($name){
        return RepositoryFactory::getRepository($name);
    }

    /**
     * Run the action.
     * Call the method with the same name than the action in the curent controller
     * 
     * @throws Exception If the action does not exist in the curent controller
     */
    public function runAction($module, $action, $args = array())
    {
        $this->module = $module;
        if (method_exists($this, $action)) {
            $this->action = $action;
            call_user_func_array(array($this, $action), $args);
        } else {
            $classController = get_class($this);
            throw new Exception("Action '$action' in not defined in the class '$classController'");
        }
    }

    public function render(Array $data)
    {
        header('Content-Type: application/json');
        echo \json_encode($data);
    }
}