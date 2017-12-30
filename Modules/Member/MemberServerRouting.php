<?php

namespace Modules\Member;

class MemberServerRouting extends \Mumux\Server\Routing{
    
    public function listRouts(){

      $this->addRoute( "ldf_users_get", "GET", "members", "MemberRoutes", "get");
      $this->addRoute( "ldf_users_post", "POST", "members", "MemberRoutes", "post");
      $this->addRoute( "ldf_users_delete", "DELETE", "members", "MemberRoutes", "delete");

      $this->addRoute( "ldf_users_getone", "GET", "members", "MemberRoutes", "getone", array("id"), array("d+"));
      $this->addRoute( "ldf_users_postone", "POST", "members", "MemberRoutes", "postone", array("id"), array("d+"));
      $this->addRoute( "ldf_users_putone", "PUT", "members", "MemberRoutes", "putone", array("id"), array("d+"));
      $this->addRoute( "ldf_users_deleteone", "DELETE", "members", "MemberRoutes", "deleteone", array("id"), array("d+"));
      
    }
}