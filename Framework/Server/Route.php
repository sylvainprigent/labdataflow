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

    public function getPutData(){
        return json_decode(file_get_contents('php://input'), true);
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

    public function render(Array $data, $code = 200)
    {

        if ($code == 403 ){
            header('HTTP/1.0 403 Forbidden');
        }
        else if ($code == 405){
            header("HTTP/1.0 405 Method Not Allowed"); 
        }

        header('Content-Type: application/json');
        echo \json_encode($data);
    }
}