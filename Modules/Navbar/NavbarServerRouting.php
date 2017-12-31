<?php

namespace Modules\Navbar;

class NavbarServerRouting extends \Mumux\Server\Routing{
    
    public function listRouts(){

      $this->addRoute( "ldf_navbar_get", "GET", "navbar", "NavbarRoutes", "get");
      
    }
}