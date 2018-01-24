<?php

namespace Modules\Breeding\ServerRoutes;

use \Mumux\Server\Route;

class SexingRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes
{

    public function __construct(\Mumux\Server\Request $request)
    {
        parent::__construct($request);
    }

    // get
    public function sexing($id_space, $id_batch)
    {
        $dataArray = $this->getRepository('Breeding::BatchRepository')->sexing($id_batch, $this->request->getParameters());
        $this->render( $dataArray );           
    }
    
}