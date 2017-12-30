<?php

namespace Modules\Auth;

class AuthClientRouting extends \Mumux\Client\Routing
{
  public function listRouts()
  {

    $this->addRoute("pm_login", "login", "login", "Modules/Auth/ClientComponents/layout.html", false);
    $this->addRoute("pm_logout", "logout", "logout", "", true);

  }
}