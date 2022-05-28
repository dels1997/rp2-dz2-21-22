<?php

require_once __DIR__ . '/../model/teamupservice.class.php';

class ApplicationsController
{
    public function index()
    {
        $user = TeamUpService::getUserByName($_SESSION['username']);
        $applicationlist = TeamUpService::getMyApplications($user->id);
        
        $projects = [];
        if(!empty($applicationlist))
        {
            foreach($applicationlist as $application)
            {
                $projects[] = [TeamUpService::getProjectByID($application->id_project), TeamUpService::getUserByID($application->id_user), $application->member_type];
            }
        }

        $title = 'List of my pending applications';

        require_once __DIR__ . '/../view/applications_index.php';
    }

    // public function owned()
    // {
    //     $user = TeamUpService::getUserByName($_SESSION['username']);
        
    //     // $user = TeamUpService::getUserByID($id_user->id);

    //     $projectlist = TeamUpService::getMyProjects($user);
    //     $title = 'List of my projects';

    //     require_once __DIR__ . '/../view/projects_index.php';
    // }

    // public function searchResults()
    // {
    //     $author = $_POST['author'];

    //     $booklist = LibraryService::getBooksByAuthor($author);
    //     $title = 'Popis svih knjiga autora ' . $author;

    //     require_once __DIR__ . '/../view/books_index.php';
    // }

    // public function list()
    // {
    //     $id_user = $_GET['id_user'];
        
    //     $user = LibraryService::getUserByID($id_user);
        
    //     $booklist = LibraryService::getLoanedBooks($user);

    //     $title = 'Popis svih knjiga koje je posudio ' . $user->name . ' ' . $user->surname;

    //     require_once __DIR__ . '/../view/books_index.php';
    // }
};

?>