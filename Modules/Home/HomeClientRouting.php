<?php

namespace Modules\Home;

class HomeClientRouting extends \Mumux\Client\Routing
{
  public function listRouts()
  {

    $this->addRoute("ldf_home", "home", "home", "layout.html", false);

  }
}