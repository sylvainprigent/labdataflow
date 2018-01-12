<?php

namespace Modules\Space\ServerRoutes;

use \Mumux\Server\Route;

class SpaceRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    public function getall()
    {
        $usersArray = $this->getRepository('Space::SpaceRepository')->selectAll();
        $this->render(array("spaces" => $usersArray));
    }

    // get all
    public function getone($id)
    {
        $dataArray = $this->getRepository('Space::SpaceRepository')->getOne($id);
        $this->render($dataArray);
    }

    // create one
    public function add()
    {

        if ($this->user['status_id'] > 1) {
            $userArray = $this->getRepository('Space::SpaceRepository')->add($this->request->getParameters());
            $this->render(array("status" => "success", "message" => "Space has been created"));
        } else {
            $this->render(array("error" => "success", "message" => "permission denied"), 403);
        }

    }
}