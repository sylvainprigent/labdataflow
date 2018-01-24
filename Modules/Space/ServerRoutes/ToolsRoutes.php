<?php

namespace Modules\Space\ServerRoutes;

use \Mumux\Server\Route;

class ToolsRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }


        // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Space::ToolRepository')->getAll($id_space);
        $this->render($dataArray);
    }
    
        // get
    public function getOne($id_space, $name_tool)
    {
        $dataArray = $this->getRepository('Space::ToolRepository')->getOne($id_space, $name_tool);
        $this->render($dataArray);
    }
    
        // post
    public function addOne($id_space)
    {
        $dataArray = $this->getRepository('Space::ToolRepository')->set($this->request->getParameters());
        $this->render($dataArray);
    }
    
        // put
    public function updateOne($id_space)
    {
        $dataArray = $this->getRepository('Space::ToolRepository')->set($this->getPutData());
        $this->render($dataArray);
    }
    
        // delete
    public function deleteOne($id_space, $name_tool)
    {
        $this->getRepository('Space::ToolRepository')->delete($name_tool);
        $this->render(array("status" => "Success", "message" => "Access has been deleted"));
    }

    // get available
    public function availableTools()
    {

        $tools = array();

        $translator = new \Mumux\Client\I18n("en");

        $modules = \Mumux\Configuration::get("Modules");
        foreach ($modules as $module) {
            $toolFile = "Modules/" . ucfirst($module) . "/Tools.json";
            if (\file_exists($toolFile)) {
                $tool = json_decode(\file_get_contents($toolFile), true);

                // translation
                $tool["name"] = $translator->tr($tool["name"]);
                $tool["description"] = $translator->tr($tool["description"]);

                $tool["id"] = $tool["confcomponent"];
                $tools[] = $tool;
            }
        }
        $this->render($tools);
    }
}