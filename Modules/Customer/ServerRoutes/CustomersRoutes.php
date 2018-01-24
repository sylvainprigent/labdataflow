<?php

namespace Modules\Customer\ServerRoutes;

use \Mumux\Server\Route;

class CustomersRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Customer::CustomerRepository')->getAll($id_space);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id_Customer){
        $dataArray = $this->getRepository('Customer::CustomerRepository')->getOne($id_space, $id_Customer);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space){
        $dataArray = $this->getRepository('Customer::CustomerRepository')->set( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Customer::CustomerRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id_Customer){
        $this->getRepository('Customer::CustomerRepository')->delete($id_Customer);
        $this->render( array("status" => "Success", "message" => "Customer has been deleted" ) );
    }


}