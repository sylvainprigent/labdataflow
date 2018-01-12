<?php

namespace Modules\Space\ServerRoutes;

use \Mumux\Server\Route;

class AccessesRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Space::AccessRepository')->getAll($id_space);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id_access){
        $dataArray = $this->getRepository('Space::AccessRepository')->getOne($id_space, $id_access);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space){
        $dataArray = $this->getRepository('Space::AccessRepository')->set( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Space::AccessRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id_access){
        $this->getRepository('Space::AccessRepository')->delete($id_access);
        $this->render( array("status" => "Success", "message" => "Access has been deleted" ) );
    }


}