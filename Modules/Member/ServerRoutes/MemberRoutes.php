<?php

namespace Modules\Member\ServerRoutes;

use \Mumux\Server\Route;

class MemberRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes{

    public function __construct( \Mumux\Server\Request $request){
        parent::__construct($request);
    }

    // get all
    public function get(){

        // \todo check authorisation 
        $usersArray = $this->getRepository('Member::MemberRepository')->selectAll();
        $this->render(array( "users" => $usersArray ));
    }

    // create one
    public function post(){
        $userArray = $this->getRepository('Member::MemberRepository')->add($this->request->getParameters());
        $this->render(array( "user" => $userArray ));
    }

    // delete all
    public function delete(){

    }

    // get one
    public function getone($id){
        $usersArray = $this->getRepository('Member::MemberRepository')->getOne($id);
        $this->render(array( "user" => $usersArray ));
    }

    // not allowed
    public function postone($id){
        // return error 405
    }

    // update one
    public function putone($id){

    }

    // delete one
    public function deleteone($id){

    }
}