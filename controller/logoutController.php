<?php

require_once __DIR__ . '/../model/teamupservice.class.php';

class logoutController
{
    public function index()
    {
        $title = 'Thank You for using our service!';

        TeamUpService::processLogout();

        require_once __DIR__ . '/../view/login_index.php';
    }
};

?>