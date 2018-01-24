<?php

namespace Modules\Customer\ServerRoutes;

use \Mumux\Server\Route;

class CustomersusersRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space, $id_Customer)
    {
        $dataArray = $this->getRepository('Customer::CustomeruserRepository')->getAll($id_Customer);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id_Customer, $id_user){
        $dataArray = $this->getRepository('Customer::CustomeruserRepository')->getOne($id_Customer, $id_user);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space, $id_Customer){
        $dataArray = $this->getRepository('Customer::CustomeruserRepository')->set( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space, $id_Customer, $id){
        $dataArray = $this->getRepository('Customer::CustomeruserRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id_Customer, $id_user){
        $this->getRepository('Customer::CustomeruserRepository')->delete($id_user);
        $this->render( array("status" => "Success", "message" => "Customer has been deleted" ) );
    }


}