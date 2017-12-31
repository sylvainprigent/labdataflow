<?php
namespace Mumux\Client;

use Mumux\Configuration;


/**
 * Class that rout the input requests
 * 
 * @author Sylvain Prigent
 */
class router
{

    public function RouterRequest()
    {
        $request = new \Mumux\Server\Request($_SERVER['REQUEST_METHOD'], array_merge($_GET, $_POST));

        $urlInfo = $this->getUrlData($request);

        /*
        if ( $urlInfo["path"] != Configuration::get("loginpath") ){

            if (!$this->hasValidToken($request)) {
                \header_remove();
                \header("Location:" . Configuration::get("rooturl") . "/" . Configuration::get("loginpath"));
            }
        }
        */

        $this->renderModule($urlInfo["module"], $urlInfo["component"], $urlInfo["layout"]);
    }

    private function hasValidToken($request)
    {
        return \Modules\Auth\ServerRoutes\AuthRoutes::checkToken($request);
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    private function getUrlData(\Mumux\Server\Request $request)
    {
        // get controller name
        $path = "";
        if ($request->isParameterNotEmpty('path')) {
            $path = $request->getParameter('path');
        }
        $path = str_replace(\Mumux\Configuration::get("rootapi"), "", $path);

        $modelCache = new \Mumux\Client\Cache();
        $pathData = $modelCache->getRouteInfo($path);

        return $pathData;
    }

    private function renderModule($moduleName, $componentName, $layoutUrl)
    {
        $content = $this->getLayoutContent($layoutUrl);
        $content = $this->insertModuleContent($moduleName, $componentName, $content);
        echo $this->replaceComponentsContent($content);
    }

    private function insertModuleContent($moduleName, $componentName, $content)
    {
        // get module html content
        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";
        $moduleContent = \file_get_contents($moduleComponentsDir . \ucfirst($componentName) . "Component.html");
        $content = \str_replace("<module></module>", $moduleContent, $content);

        // get module css and js content
        $head = $this->getComponentHeader($moduleName, $componentName);
        $content = \str_replace("<module-scripts></module-scripts>", $head . "<module-scripts></module-scripts>", $content);
        return $content;
    }

    private function getLayoutContent($layoutUrl)
    {
        if ($layoutUrl == "") {
            $html = "<!DOCTYPE html><html><head><module-scripts></module-scripts></head><body><module></module></body></html>";
        } else {
            $html = \file_get_contents($layoutUrl);
        }
        return $html;
    }

    public function getComponentHeader($moduleName, $componentName)
    {
        $head = "";
        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";

        $cssFile = $moduleComponentsDir . $componentName . "Component.css";
        if (\file_exists($cssFile)) {
            $head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssFile . "\">";
        }

        $jsFile = $moduleComponentsDir . $componentName . "Component.js";
        if (\file_exists($jsFile)) {
            $head .= "<script src=\"" . $jsFile . "\"></script>";

        }

        return $head;
    }

    protected function replaceComponentsContent($content)
    {

        $found = false;

        $modules = \scandir("Modules");
        foreach ($modules as $module) {

            if (!$this->startsWith($module, ".")) {

                $moduleDir = "Modules/" . $module;

                $files = \scandir($moduleDir . "/ClientComponents/");
                foreach ($files as $file) {
                    //echo "try to find component file " . $file . "<br/>";
                    if ($this->endsWith($file, "Component.html")) {
                        $componentName = \str_replace("Component.html", "", $file);
                        //echo "try to replace component " . $componentName . "<br/>";
                        $m = strtolower($componentName);
                        $tag = "<" . $m . "></" . $m . ">";
                        if (strstr($content, $tag)) {
                            //echo "found a tag to replace component " . $componentName . "<br/>";
                            $found = true;
                            $content = $this->replaceTagContent($tag, $module, $componentName, $content);
                        }
                    }
                }
            }
        }

        if ($found) {
            $content = $this->replaceComponentsContent($content);
        }
        return $content;
    }

    protected function replaceTagContent($tag, $moduleName, $componentName, $content)
    {
        // get component html content
        $moduleComponentsDir = "Modules/" . $moduleName . "/ClientComponents/";
        $moduleContent = \file_get_contents($moduleComponentsDir . $componentName . "Component.html");
        $content = \str_replace($tag, $moduleContent, $content);
        
        // get module css and js content
        $head = $this->getComponentHeader($moduleName, $componentName);
        $content = \str_replace("<module-scripts></module-scripts>", $head . "<module-scripts></module-scripts>", $content);
        return $content;
    }

    protected function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

    protected function startsWith($haystack, $needle)
    {
        if (strpos($haystack, $needle) === 0) {
            return true;
        }
        return false;
    }
}

