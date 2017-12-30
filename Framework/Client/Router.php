<?php
namespace Mumux\Client;

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

        $this->renderModule($urlInfo["module"], $urlInfo["component"], $urlInfo["layout"]);
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





/*
    private function renderModuleOld($moduleName, $componentName, $layoutUrl)
    {

        // get the layout
        if ($layoutUrl == "") {
            $html = "<!DOCTYPE html><html><head><module-scripts></module-scripts></head><body><module></module></body></html>";
        } else {
            $html = \file_get_contents($layoutUrl);
        }
        $head = "";

        // replace each module directly in the layout
        $modules = \scandir("Modules");

        foreach ($modules as $module) {
            $m = strtolower($module);
            $tag = "<" . $m . "></" . $m . ">";
            if (strstr($html, $tag)) {
                $moduleContent = $this->getModuleContent($module, $module);
                $head .= $this->getModuleHeader($module);
                $html = \str_replace($tag, $moduleContent, $html);
            }
        }
        
        // replace the data in the main layout
        $moduleContent = $this->getModuleContent($moduleName, $componentName);
        $head .= $this->getModuleHeader($moduleName);

        $html = \str_replace("<module-scripts></module-scripts>", $head, $html);
        echo \str_replace("<module></module>", $moduleContent, $html);
    }

    protected function getModuleContent($moduleName, $routeName)
    {
        $moduleComponentsDir = "Modules/" . $moduleName . "/ClientComponents/";

        // get the module root HTML
        $moduleContent = \file_get_contents($moduleComponentsDir . $routeName . ".html");

        // replace the components in the module html
        $files = \scandir($moduleComponentsDir);
        foreach ($files as $file) {

            if ($this->endsWith($file, "Component.html")) {
                $componentContent = \file_get_contents($moduleComponentsDir . $file);
                $componentName = \strtolower(\str_replace("Component.html", "", $file));
                $moduleContent = \str_replace("<" . $componentName . "></" . $componentName . ">", $componentContent, $moduleContent);
            }
        }

        return $moduleContent;
    }

    protected function getModuleHeader($moduleName)
    {
        $moduleComponentsDir = "Modules/" . $moduleName . "/ClientComponents/";

        $files = \scandir($moduleComponentsDir);
        $head = "";
        foreach ($files as $file) {
            if ($this->endsWith($file, "js")) {
                $head .= "<script src=\"" . $moduleComponentsDir . $file . "\"></script>";
            } else if ($this->endsWith($file, "css")) {
                $head .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $moduleComponentsDir . $file . "\">";
            }
        }

        return $head;
    }
     */
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

