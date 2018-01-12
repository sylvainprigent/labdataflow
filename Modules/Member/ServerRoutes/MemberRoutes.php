<?php

namespace Modules\Member\ServerRoutes;

use \Mumux\Server\Route;

class MemberRoutes extends \Modules\Auth\ServerRoutes\AuthRoutes{

    public function __construct( \Mumux\Server\Request $request){
        parent::__construct($request);
    }

    public function getall(){
        $usersArray = $this->getRepository('Member::MemberRepository')->selectAll();
        $this->render($usersArray);
    }

    public function getfilter($filter){
        $usersArray = $this->getRepository('Member::MemberRepository')->selectFilter($filter);
        $this->render($usersArray);
    }

    public function getone($id){
        $usersArray = $this->getRepository('Member::MemberRepository')->getOne($id);
        $this->render($usersArray);
    }

    public function add(){
        if ($this->user['status_id'] > 1){
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
        else{
            $this->render(array( "error" => "success", "message" => "permission denied" ), 403);
        }
    }

    // update one
    public function edit($id){

        if ($this->user['status_id'] > 1){
            $this->getRepository('Member::MemberRepository')->put($id, $this->getPutData());
            $this->render(array( "status" => "success", "message" => "User has been modified" ));
        }
        else{
            $this->render(array( "status" => "error", "message" => "permission denied" ), 403);
        }
    }
}
