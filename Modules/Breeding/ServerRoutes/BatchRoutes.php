<?php

namespace Modules\Breeding\ServerRoutes;

use \Mumux\Server\Route;

class BatchRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Breeding::BatchRepository')->getAll($id_space);
        $this->render( $dataArray );           
    }

    public function getAllOpened($id_space){
        $dataArray = $this->getRepository('Breeding::BatchRepository')->getAllOpened($id_space);
        $this->render( $dataArray );  
    }

    public function getAllClosed($id_space){
        $dataArray = $this->getRepository('Breeding::BatchRepository')->getAllClosed($id_space);
        $this->render( $dataArray );  
    }

    // get
    public function getOne($id_space, $id){
        $dataArray = $this->getRepository('Breeding::BatchRepository')->getOne($id_space, $id);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space){
        $dataArray = $this->getRepository('Breeding::BatchRepository')->add( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Breeding::BatchRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id){
        $this->getRepository('Breeding::BatchRepository')->delete($id);
        $this->render( array("status" => "Success", "message" => "Data has been deleted" ) );
    }
}