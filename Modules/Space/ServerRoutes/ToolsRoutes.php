<?php

namespace Modules\Space\ServerRoutes;

use \Mumux\Server\Route;

class ToolsRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    
    public function getAll(){

        $tools = array();

        $translator = new \Mumux\Client\I18n("en");

        $modules = \Mumux\Configuration::get("Modules");
        foreach ($modules as $module){
            $toolFile = "Modules/" . ucfirst($module) . "/Tools.json";
            if ( \file_exists($toolFile)){
                $tool = json_decode( \file_get_contents($toolFile), true);

                // translation
                $tool["name"] = $translator->tr($tool["name"]);
                $tool["description"] = $translator->tr($tool["description"]);

                $tool["id"] = $tool["confcomponent"];
                $tools[] = $tool;
            }
        }
        $this->render($tools);
    }

    public function getSpace($id_space)
    {

        $tools = array();
        $tools[] = array( "name" => "Booking",
                   "icon" => "fa-calendar",
                   "url"  => "calendar",
                   "color"  => "#FFBB88"          
                    );
                    $tools[] = array( "name" => "Booking",
                    "icon" => "fa-calendar",
                    "url"  => "calendar",
                    "color"  => "#00EE88"            
                     );            
        
        
        $this->render(array("tools" => $tools));

    }

}