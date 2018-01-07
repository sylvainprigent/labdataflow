<?php

namespace Modules\Member\ServerRoutes;

use \Mumux\Server\Route;

class MemberRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes{

    public function __construct( \Mumux\Server\Request $request){
        parent::__construct($request);
    }

    // get all
    public function get($id, $filter, $limit){

        if ($id > 0){
            $usersArray = $this->getRepository('Member::MemberRepository')->getOne($id);
            $this->render($usersArray);
            return;
        }
        else{
            if ( $filter != ""){
                $usersArray = $this->getRepository('Member::MemberRepository')->selectFilter($filter);
            }
            else{
                $usersArray = $this->getRepository('Member::MemberRepository')->selectAll();
            }            
        }
        $this->render(array( "users" => $usersArray ));
        
    }

    // create one
    public function post(){

        $pwd = $this->request->getParameter("password");
        $pwdconfirm = $this->request->getParameter("passwordconfirm");
        
        if ( $pwd != $pwdconfirm ){
            $this->render(array( "status" => "error", "code" => 1, "message" => "The two passwords are differents" ));
            return;
        }
        if ( $this->getRepository('Member::MemberRepository')->exists($this->request->getParameter("login")) ){
            $this->render(array( "status" => "error", "code" => 2, "message" => "The login is already in use" ));
            return;
        }

        $userArray = $this->getRepository('Member::MemberRepository')->add($this->request->getParameters());
        $this->render(array( "status" => "success", "message" => "User has been created" ));
        
    }

    // delete all
    public function delete(){

    }

 

    // not allowed
    public function postone($id){
        // return error 405
    }

    // update one
    public function putone($id){
        
        $this->getRepository('Member::MemberRepository')->put($id, $this->getPutData());
        $this->render(array( "status" => "success", "message" => "User has been modified" ));
    }

    // delete one
    public function deleteone($id){

    }
}