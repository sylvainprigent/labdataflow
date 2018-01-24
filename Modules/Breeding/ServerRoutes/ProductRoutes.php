<?php

namespace Modules\Breeding\ServerRoutes;

use \Mumux\Server\Route;

class ProductRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Breeding::ProductRepository')->getAll($id_space);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id){
        $dataArray = $this->getRepository('Breeding::ProductRepository')->getOne($id_space, $id);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space){
        $dataArray = $this->getRepository('Breeding::ProductRepository')->set( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Breeding::ProductRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id){
        $this->getRepository('Breeding::ProductRepository')->delete($id);
        $this->render( array("status" => "Success", "message" => "Data has been deleted" ) );
    }
}