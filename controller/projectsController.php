<?php

require_once __DIR__ . '/../model/teamupservice.class.php';

class ProjectsController
{
    public function index()
    {
        $projectlist = TeamUpService::getAllProjects();
        $title = 'List of all projects';

        require_once __DIR__ . '/../view/projects_index.php';
    }

    public function owned()
    {
        $user = TeamUpService::getUserByName($_SESSION['username']);
        
        // $user = TeamUpService::getUserByID($id_user->id);

        $projectlist = TeamUpService::getMyProjects($user);
        $title = 'List of my projects';

        require_once __DIR__ . '/../view/projects_index.php';
    }

    public function searchResults()
    {
        $author = $_POST['author'];

        $booklist = LibraryService::getBooksByAuthor($author);
        $title = 'Popis svih knjiga autora ' . $author;

        require_once __DIR__ . '/../view/books_index.php';
    }

    public function list()
    {
        $id_user = $_GET['id_user'];
        
        $user = LibraryService::getUserByID($id_user);
        
        $booklist = LibraryService::getLoanedBooks($user);

        $title = 'Popis svih knjiga koje je posudio ' . $user->name . ' ' . $user->surname;

        require_once __DIR__ . '/../view/books_index.php';
    }

    public function show()
    {
        $id_project = $_GET['id_project'];

        $project_current = TeamUpService::getProjectByID($id_project);

        $id_user = $project_current->id_user;

        $user = TeamUpService::getUserByID($id_user);

        $memberlist = TeamUpService::getProjectMembersByID($id_project);

        $projectlist = [];
        $projectlist[] = [$project_current, $user->username];

        $logged_user = TeamUpService::getUserByName($_SESSION['username']);

        $iAmAuthor = ($id_user === $logged_user->id);

        $member_already = TeamUpService::isMemberOf($logged_user->id, $id_project);

        $title = 'Info about project ' . $project_current->title . '</br>';

        $applicationlist = TeamUpService::getProjectApplicationsByID($id_project);

        require_once __DIR__ . '/../view/projects_show.php';
    }

    public function apply()
    {
        $id_project = $_GET['id_project'];

        $project_current = TeamUpService::getProjectByID($id_project);

        $logged_user = TeamUpService::getUserByName($_SESSION['username']);

        $id_user = $project_current->id_user;

        $user = TeamUpService::getUserByID($id_user);

        $memberlist = TeamUpService::getProjectMembersByID($id_project);

        $member_already = TeamUpService::isMemberOf($logged_user->id, $id_project);

        $project_full = TeamUpService::projectFull($id_project);

        $application_successfull = False;

        if(!($member_already || $project_full))
        {
            TeamUpService::addMember($logged_user->id, $id_project);
            $application_successfull = True;
        }

        // $projectlist = [];
        // $projectlist[] = [$project_current, $user->username];

        // $title = 'Info about project ' . $project_current->title . '</br>';
        $title = 'Application status';

        require_once __DIR__ . '/../view/projects_apply.php';
    }

    public function invite()
    {
        $id_project = $_GET['id_project'];

        $invited_user = TeamUpService::getUserByName($_POST['person_to_invite']);

        $logged_user = TeamUpService::getUserByName($_SESSION['username']);

        // $id_user = $project_current->id_user;

        // $user = TeamUpService::getUserByID($id_user);

        // $memberlist = TeamUpService::getProjectMembersByID($id_project);

        $member_already = TeamUpService::isMemberOf($invited_user->id, $id_project);

        $project_full = TeamUpService::projectFull($id_project);

        $invitation_successfull = False;

        if(!($member_already || $project_full))
        {
            $invitation_successfull = TeamUpService::inviteMember($invited_user->id, $id_project);
        }

        // $projectlist = [];
        // $projectlist[] = [$project_current, $user->username];

        // $title = 'Info about project ' . $project_current->title . '</br>';
        $title = 'Invitation status';

        // // ----- KOPIRANO IZ SHOW
        // $id_project = $_GET['id_project'];

        // $project_current = TeamUpService::getProjectByID($id_project);

        // $id_user = $project_current->id_user;

        // $user = TeamUpService::getUserByID($id_user);

        // $memberlist = TeamUpService::getProjectMembersByID($id_project);

        // $projectlist = [];
        // $projectlist[] = [$project_current, $user->username];

        // $logged_user = TeamUpService::getUserByName($_SESSION['username']);

        // $iAmAuthor = ($id_user === $logged_user->id);

        // $member_already = TeamUpService::isMemberOf($logged_user->id, $id_project);

        // $title = 'Info about project ' . $project_current->title . '</br>';
        // // ----

        require_once __DIR__ . '/../view/projects_invite.php';
    }

    public function decision()
    {
        // $user = TeamUpService::getUserByName($_SESSION['username']);
        // $invitationlist = TeamUpService::getMyInvitations($user->id);

        // $projects = [];
        // if(!empty($invitationlist))
        // {
        //     foreach($invitationlist as $invitation)
        //     {
        //         $project = TeamUpService::getProjectByID($invitation->id_project);
        //         $inviting_user = TeamUpService::getUserByID($project->id_user);
        //         $projects[] = [TeamUpService::getProjectByID($invitation->id_project), $inviting_user, $invitation->member_type];
        //     }
        // }

        $id_project = $_GET['id_project'];

        $application_accepted = False;
        if(isset($_POST['accept']))
        {
            $current_user = TeamUpService::getUserByName($_SESSION['username']);
            TeamUpService::acceptApplication($_POST['id_user'], $_GET['id_project']);
            $application_accepted = True;
        }
        else
        {
            $current_user = TeamUpService::getUserByName($_SESSION['username']);
            TeamUpService::rejectApplication($_POST['id_user'], $_GET['id_project']);
        }

        $title = 'Application status';

        require_once __DIR__ . '/../view/projects_decision.php';
    }
};

?>