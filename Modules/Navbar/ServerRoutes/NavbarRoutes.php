<?php

namespace Modules\Navbar\ServerRoutes;

use \Mumux\Server\Route;

class NavbarRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes{

    public function __construct( \Mumux\Server\Request $request){
        parent::__construct($request);
    }

    // get all
    public function get(){

        $user = $this->getRepository('Member::MemberRepository')->getOne($this->user['id']);
        $this->render(array( "user" => $user ));
    }

 
}