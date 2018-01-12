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
    protected $path;

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

            // get args
            $action = $urlInfo["pathInfo"]["action"];
            $args = $this->getArgs($urlInfo);

            // create controller
            $controller = $this->createController($urlInfo["pathInfo"]["module"], 
                $urlInfo["pathInfo"]["route"], 
                $request
            );

            // run action
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
        $this->path = $path;
        $path = str_replace(\Mumux\Configuration::get("rootapi"), "", $path);

        $regexpPath = $this->getUrlRegexpPath($path);
        //echo 'regexpPath = ' . $regexpPath . "<br/>";
        //echo 'request type = ' . $request->getType() . "<br/>";
        $pathInfo = $this->modelCache->getURLInfos($request->getType(), $regexpPath);

        return array("path" => $path, "pathRegex" => $regexpPath, "pathInfo" => $pathInfo);
    }

    protected function getUrlRegexpPath($url)
    {

        $pathData = explode("/", $url);
        $path = $pathData[0];
        $regexp = $path;

        if (count($pathData) > 1) {
            $pos = 1;
            while ($pos < count($pathData)) {
                
                if (is_numeric($pathData[$pos])) {
                    $regexp .= "/d";
                    $pos++;
                } else {
                    $regexp .= "/" . $pathData[$pos];
                    if ( isset($pathData[$pos + 1]) ){
                        if (is_numeric($pathData[$pos + 1])) {
                            $regexp .= "/d";
                        } else {
                            $regexp .= "/w";
                        }
                    }

                    $pos += 2;
                }
            }
        }
        return $regexp;
    }



    /**
     * Instantiate the controller dedicated to the request
     *
     * @param Request $request
     *        	Input Request
     * @return Instance of a controller
     * @throws Exception If the controller cannot be instanciate
     */
    private function createController($moduleName, $controllerName, Request $request)
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

        $path = explode( "/", $urlInfo["path"] );
        $pathRegex = explode( "/", $urlInfo["pathRegex"]);

        $argsValues = array();
        for( $i = 0 ; $i < count($path) ; $i++){
            if ( $pathRegex[$i] == "d" || $pathRegex[$i] == "w" ){
                $argsValues[] = $path[$i];
            }
        }
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
            'path' => $this->path,
            'message' => $exception->getMessage()
        );
        header('Content-Type: application/json');
        echo \json_encode($data);
    }

}