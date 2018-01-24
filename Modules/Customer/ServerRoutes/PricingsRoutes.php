<?php

namespace Modules\Customer\ServerRoutes;

use \Mumux\Server\Route;

class PricingsRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function getAll($id_space)
    {
        $dataArray = $this->getRepository('Customer::PricingRepository')->getAll($id_space);
        $this->render( $dataArray );           
    }

    // get
    public function getOne($id_space, $id_pricing){
        $dataArray = $this->getRepository('Customer::PricingRepository')->getOne($id_space, $id_pricing);
        $this->render( $dataArray );  
    }

    // post
    public function addOne($id_space){
        $dataArray = $this->getRepository('Customer::PricingRepository')->set( $this->request->getParameters() );
        $this->render( $dataArray );   
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Customer::PricingRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

    // delete
    public function deleteOne($id_space, $id_pricing){
        $this->getRepository('Customer::PricingRepository')->delete($id_pricing);
        $this->render( array("status" => "Success", "message" => "Pricing has been deleted" ) );
    }


}