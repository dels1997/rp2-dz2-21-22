<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class usersController
{
    public function index()
    {
        $userlist = LibraryService::getAllUsers();
        $title = 'Popis svih korisnika';

        require_once __DIR__ . '/../view/users_index.php';
    }
};

?>