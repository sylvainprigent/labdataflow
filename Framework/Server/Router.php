<?php
namespace Mumux\Server;

/**
 * Class that rout the input requests
 * 
 * @author Sylvain Prigent
 */
class router
{

    protected $modelCache;
    protected $useRouterController;

    public function __construct()
    {
        $this->modelCache = new Cache();
    }

    public function routerRequest()
    {
        try {
            // Merge parameters GET and POST
            $request = new Request($_SERVER['REQUEST_METHOD'], array_merge($_GET, $_POST));

            $urlInfo = $this->getUrlData($request);

            //print_r($urlInfo);

            $controller = $this->createController($urlInfo, $request);

            $action = $urlInfo["pathInfo"]["action"];
            $args = $this->getArgs($urlInfo);

            // parse arfs

            $this->runAction($controller, $urlInfo, $action, $args);

        } catch (\Exception $e) {
            $this->manageError($e);
        }
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    private function getUrlData(Request $request)
    {
        // get controller name
        $path = "";
        if ($request->isParameterNotEmpty('path')) {
            $path = $request->getParameter('path');
        }
        $path = str_replace(\Mumux\Configuration::get("rootapi"), "", $path);
 
        $pathData = explode("/", $path);
        //echo 'path 0 = ' . $pathData[0] . "<br/>";
        //echo 'request type = ' . $request->getType() . "<br/>";
        $pathInfo = $this->modelCache->getURLInfos($request->getType(), $pathData[0]);
        return array("pathData" => $pathData, "pathInfo" => $pathInfo);
    }

    /**
     * 
     * @param type $urlInfo
     * @param Request $request
     * @return type
     */
    private function createController($urlInfo, Request $request)
    {
        //print_r($urlInfo);
        return $this->createControllerImp($urlInfo["pathInfo"]["module"], $urlInfo["pathInfo"]["route"], $request);
    }

    /**
     * Instantiate the controller dedicated to the request
     *
     * @param Request $request
     *        	Input Request
     * @return Instance of a controller
     * @throws Exception If the controller cannot be instanciate
     */
    private function createControllerImp($moduleName, $controllerName, Request $request)
    {
        $classController = '\\Modules\\' . $moduleName . "\\ServerRoutes\\" . $controllerName;
        $fileController = 'Modules/' . $moduleName . '/ServerRoutes/' . $controllerName . ".php";
    
        if (file_exists($fileController)) {
            $controller = new $classController($request);
            return $controller;
        } else {
            throw new \Exception("Unable to find the controller file '$fileController' ");
        }
    }

    /**
     * 
     * @param type $urlInfo
     * @return string
     */
    private function getArgs($urlInfo)
    {

        $args = $urlInfo["pathInfo"]["gets"];
        $argsvals = $urlInfo["pathData"];
        $argsValues = array();

        if (count($args) == 0){
            return $argsValues;
        }

        //echo "argval:" . $argsvals[1] . "<br/>";

        for ($i = 0; $i < count($args); $i++) {

            if ( $args[$i]["name"] == ":id" ){
                if ( intval($argsvals[1]) > 0 ){
                    $argsValues["id"] = intval($argsvals[1]);
                }
                else{
                    $argsValues["id"] = 0;
                }
            } 
            else{

                $key = array_search($args[$i]["name"], $argsvals);
                if ( $key ){
                    $argsValues[$args[$i]["name"]] = $argsvals[$key + 1];
                }
                else{
                    $argsValues[$args[$i]["name"]] = "";
                }
            }

        }

        //print_r($argsValues);
        return $argsValues;
    }

    protected function runAction($controller, $urlInfo, $action, $args)
    {

        try {
            $controller->runAction($urlInfo["pathInfo"]["module"], $action, $args);
        } catch (Exception $ex) {
            echo json_encode(array(
                'error' => array(
                    'msg' => $ex->getMessage(),
                    'code' => $ex->getCode(),
                ),
            ));
        }

    }

    /**
     * Manage error (exception)
     *
     * @param Exception $exception
     *        	Thrown exception
     */
    private function manageError(\Exception $exception, $type = 'Error')
    {

        $data = array(
            'type' => $type,
            'message' => $exception->getMessage()
        );
        header('Content-Type: application/json');
        echo \json_encode($data);
    }

}