<?php

namespace Modules\Auth;

class AuthServerRouting extends \Mumux\Server\Routing{
    
    public function listRouts(){

      $this->addRoute( "pm_auth_login", "POST", "login", "LoginRoutes", "login");
      
    }

    
}