<?php

namespace Modules\Customer\ServerRoutes;

use \Mumux\Server\Route;

class CompaniesRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function get($id_space)
    {
        $dataArray = $this->getRepository('Customer::CompanyRepository')->get($id_space);
        $this->render( $dataArray );           
    }

    // put
    public function updateOne($id_space){
        $dataArray = $this->getRepository('Customer::CompanyRepository')->set( $this->getPutData() );
        $this->render( $dataArray ); 
    }

}