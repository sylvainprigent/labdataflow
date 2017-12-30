<?php

namespace Modules\Member;

class MemberClientRouting extends \Mumux\Client\Routing{
    
    public function listRouts(){

      $this->addRoute( "lf_members", "member", "member", "layout.html", true);
      
    }
}