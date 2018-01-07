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

        if (Configuration::get("usecache")) {
            $this->renderModuleCache($moduleName, $componentName, $layoutUrl);
        } else {
            $this->renderModuleNoCache($moduleName, $componentName, $layoutUrl);
        }
    }

    private function renderModuleCache($moduleName, $componentName, $layoutUrl)
    {

        // get cache dir 
        $cacheDir = "web/cache/" . \ucfirst($moduleName);
        if (Configuration::get("usei18n")) {
            $translator = new \Mumux\Client\I18n();
            $cacheDir = "web/cache/" . \ucfirst($moduleName) . "/" . $translator->getLang();
        }

        $htmlFile = $cacheDir . "/" . $moduleName . ".html";
        if (!\file_exists($htmlFile)) {
            $this->generateModuleCache($moduleName, $componentName, $layoutUrl, $cacheDir);
        }
        echo \file_get_contents($htmlFile);

    }

    private function generateModuleCache($moduleName, $componentName, $layoutUrl, $cacheDir)
    {

        // create cache files
        if (!\file_exists($cacheDir)) {
            if (!\mkdir($cacheDir, 0777, true)) {
                throw new \Exception("cannot create the cache dir " . $cacheDir);
            }
        } 
                // create files
        $htmlFile = $cacheDir . "/" . $moduleName . ".html";
        $jsFile = $cacheDir . "/" . $moduleName . ".js";
        $cssFile = $cacheDir . "/" . $moduleName . ".css";
        \touch($htmlFile);
        \touch($jsFile);
        \touch($cssFile);
        $files = array("html" => $htmlFile, "js" => $jsFile, "css" => $cssFile);


        // get the module base component
        $html = $this->getLayoutContent($layoutUrl);
        $html = $this->insertModuleContent($moduleName, $componentName, $html, false);
        $head = "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $files["css"] . "\">" . PHP_EOL;;
        $head .= "<script src=\"" . $files["js"] . "\"></script>";
        $html = \str_replace("<module-scripts></module-scripts>", $head, $html);
        \file_put_contents($files["html"], $html, FILE_APPEND);

        $js = $this->getComponentJs($moduleName, $componentName);
        \file_put_contents($files["js"], $js, FILE_APPEND);

        $css = $this->getComponentCss($moduleName, $componentName);
        \file_put_contents($files["css"], $css, FILE_APPEND);

        // recurcively add the other components
        $this->insertComponentsContent($files);

        // translate
        if (\Mumux\Configuration::get("usei18n")) {
            $tranlsator = new I18n();
            \file_put_contents($files["html"], $tranlsator->translate(\file_get_contents($files["html"])));
            \file_put_contents($files["js"], $tranlsator->translate(\file_get_contents($files["js"])));
        }



    }

    private function renderModuleNoCache($moduleName, $componentName, $layoutUrl)
    {
        $content = $this->getLayoutContent($layoutUrl);
        $content = $this->insertModuleContent($moduleName, $componentName, $content);
        $content = $this->replaceComponentsContent($content);

        /*
        if (\Mumux\Configuration::get("usei18n")) {
            $tranlsator = new I18n();
            $content = $tranlsator->translate($content);
        }
         */
        echo $content;
    }


    private function getComponentHtml($moduleName, $componentName)
    {
        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";
        $htmlFile = $moduleComponentsDir . $componentName . "Component.html";
        return \file_get_contents($htmlFile);
    }

    private function getComponentJs($moduleName, $componentName)
    {

        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";
        $jsFile = $moduleComponentsDir . $componentName . "Component.js";
        return \file_get_contents($jsFile);
    }

    private function getComponentCss($moduleName, $componentName)
    {
        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";
        $cssFile = $moduleComponentsDir . $componentName . "Component.css";
        if (\file_exists($cssFile)) {
            return \file_get_contents($cssFile);
        }

    }

    private function insertModuleContent($moduleName, $componentName, $content, $replaceHeader = true)
    {
        // get module html content
        $moduleComponentsDir = "Modules/" . \ucfirst($moduleName) . "/ClientComponents/";
        $moduleContent = \file_get_contents($moduleComponentsDir . \ucfirst($componentName) . "Component.html");
        $content = \str_replace("<module></module>", $moduleContent, $content);

        if ($replaceHeader) {
            // get module css and js content
            $head = $this->getComponentHeader($moduleName, $componentName);
            $content = \str_replace("<module-scripts></module-scripts>", $head . "<module-scripts></module-scripts>", $content);
        }
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


    protected function insertComponentsContent($files)
    {
        $found = false;

        $modules = \scandir("Modules");
        foreach ($modules as $module) {

            if (!$this->startsWith($module, ".")) {

                $moduleDir = "Modules/" . $module;

                $modulesFiles = \scandir($moduleDir . "/ClientComponents/");
                foreach ($modulesFiles as $file) {
                    if ($this->endsWith($file, "Component.html")) {
                        $componentName = \str_replace("Component.html", "", $file);
                        $m = strtolower($componentName);
                        $tag = "<" . $m . "></" . $m . ">";

                        $html = \file_get_contents($files["html"]);
                        if (strstr($html, $tag)) {
                            $found = true;

                            // insert html
                            \file_put_contents($files["html"], \str_replace($tag, $this->getComponentHtml($module, $componentName), $html));

                            // insert js
                            \file_put_contents($files["js"], $this->getComponentJs($module, $componentName), FILE_APPEND);

                            // insert css
                            \file_put_contents($files["css"], $this->getComponentCss($module, $componentName), FILE_APPEND);
                        }
                    }
                }
            }
        }

        if ($found) {
            $this->insertComponentsContent($files);
        }
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

