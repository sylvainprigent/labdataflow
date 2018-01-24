<?php

namespace Modules\Breeding\ServerRoutes;

use \Mumux\Server\Route;

class ChippingRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space, $id_batch)
    {
        $dataArray = $this->getRepository('Breeding::ChippingRepository')->getAll($id_space, $id_batch);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id_batch, $id){
        $dataArray = $this->getRepository('Breeding::ChippingRepository')->getOne($id_space, $id_batch, $id);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space, $id_batch){

        $dataArray = $this->getRepository('Breeding::ChippingRepository')->add( $id_batch, $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space, $id_batch){
        $dataArray = $this->getRepository('Breeding::ChippingRepository')->set( $id_batch, $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id_batch, $id){
        $this->getRepository('Breeding::ChippingRepository')->delete($id);
        $this->render( array("status" => "Success", "message" => "Data has been deleted" ) );
    }
}