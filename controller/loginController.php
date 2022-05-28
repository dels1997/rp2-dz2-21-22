<?php

require_once __DIR__ . '/../model/teamupservice.class.php';

class loginController
{
    public function index()
    {
        $title = 'Please input your username and password...';

        $rez = TeamUpService::processLogin();

        if($rez)
        {
            $projectlist = $rez;
            
            require_once __DIR__ . '/../view/projects_index.php';
        }
        else
            require_once __DIR__ . '/../view/login_index.php';
    }
};

?>