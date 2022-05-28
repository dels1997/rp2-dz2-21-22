<?php

require_once __DIR__ . '/../app/database/db.class.php';
require_once __DIR__ . '/user.class.php';
require_once __DIR__ . '/member.class.php';
require_once __DIR__ . '/project.class.php';

class TeamUpService
{
    public static function getUserByID($id_user)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_users WHERE id=:id');
        $st->execute(['id' => $id_user]);

        $row = $st->fetch();

        return new User($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);    
    }

    public static function getUserByName($username)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_users WHERE username=:username');
        $st->execute(['username' => $username]);

        $row = $st->fetch();

        return new User($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);    
    }

    public static function getAuthorByProjectID($id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_projects WHERE id=:id');
        $st->execute(['id' => $id_project]);

        $row = $st->fetch();
        $id_user = $row['id_user'];

        $st = $db->prepare('SELECT * FROM dz2_users WHERE id=:id');
        $st->execute(['id' => $id_user]);

        $row = $st->fetch();

        return new User($row['id'], $row['username'], $row['password_hash'], $row['email'], $row['registration_sequence'], $row['has_registered']);    
    }

    public static function getMyProjects($user)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_user=:id_user');
        $st->execute(['id_user' => $user->id]);

        $projects = [];
        while($row = $st->fetch())
        {
            $id_project = $row['id_project'];
            $project = TeamUpService::getProjectByID($id_project);
            $user = TeamUpService::getAuthorByProjectID($project->id);
            $projects[] = [TeamUpService::getProjectByID($id_project), $user->username, null];
        }

        return $projects;
    }

    public static function getProjectByID($id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_projects WHERE id=:id');
        $st->execute(['id' => $id_project]);

        $row = $st->fetch();

        return new Project($row['id'], $row['id_user'], $row['title'], $row['abstract'], $row['number_of_members'], $row['status']);   
    }

    public static function getMyInvitations($id_user)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_user=:id_user');
        $st->execute(['id_user' => $id_user]);

        $row = $st->fetch();

        $invitations = [];

        while($row = $st->fetch())
        {
            if($row['member_type'] == 'invitation_pending')
                $invitations[] = new Member($row['id'], $row['id_project'], $row['id_user'], $row['member_type']);
        }

        return $invitations;
    }

    public static function getMyApplications($id_user)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_user=:id_user');
        $st->execute(['id_user' => $id_user]);

        $row = $st->fetch();

        $applications = [];

        while($row = $st->fetch())
        {
            if($row['member_type'] == 'application_pending' || $row['member_type'] == 'application_accepted' || $row['member_type'] == 'application_rejected')
                $applications[] = new Member($row['id'], $row['id_project'], $row['id_user'], $row['member_type']);
        }

        return $applications;
    }

    public static function getProjectMembersByID($id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_project=:id_project');
        $st->execute(['id_project' => $id_project]);
        
        $project = TeamUpService::getProjectByID($id_project);

        $user = TeamUpService::getUserByID($project->id_user);

        $memberlist = [];
        while($row = $st->fetch())
        {
            if($row['member_type'] === 'member' || $row['member_type'] === 'invitation_accepted' || $row['member_type'] === 'application_accepted')
            {
                $id_member = $row['id_user'];
                if($id_member !== $user->id)
                    $memberlist[] = TeamUpService::getUserByID($id_member);
            }
        }

        return $memberlist;
    }

    public static function isMemberOf($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_project=:id_project');
        $st->execute(['id_project' => $id_project]);
        
        while($row = $st->fetch())
        {
            if($row['member_type'] === 'member' || $row['member_type'] === 'invitation_accepted' || $row['member_type'] === 'application_accepted')
            {
                if($row['id_user'] === $id_user)
                    return True;
            }
        }
        return False;
    }

    public static function projectFull($id_project)
    {
        
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_project=:id_project');
        $st->execute(['id_project' => $id_project]);
        
        $broj_clanova = 0;
        while($row = $st->fetch())
        {
            if($row['member_type'] === 'member' || $row['member_type'] === 'invitation_accepted' || $row['member_type'] === 'application_accepted')
                ++$broj_clanova;
        }

        $project = TeamUpService::getProjectByID($id_project);
        $dopusteni_broj_clanova = $project->number_of_members;

        return $broj_clanova >= $dopusteni_broj_clanova;
    }

    public static function addMember($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('INSERT INTO dz2_members (id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)');
        $st->execute(['id_project' => $id_project, 'id_user' => $id_user, 'member_type' => 'member']);
    }

    public static function acceptInvitation($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('UPDATE dz2_members SET member_type=:member_type WHERE id_project=:id_project AND id_user=:id_user');

        echo $st->execute(['member_type' => 'invitation_accepted', 'id_project' => $id_project, 'id_user' => $id_user]);
    }

    public static function rejectInvitation($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('UPDATE dz2_members SET member_type=:member_type WHERE id_project=:id_project AND id_user=:id_user');
        $st->execute(['member_type' => 'invitation_rejected', 'id_project' => $id_project, 'id_user' => $id_user]);
    }

    public static function inviteMember($id_invited_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_project=:id_project AND id_user=:id_user AND (member_type=:member_type1 OR member_type=:member_type2 OR member_type=:member_type3 OR member_type=:member_type4)');
        $st->execute(['member_type1' => 'invitation_pending', 'member_type2' => 'invitation_rejected',  'member_type3' => 'application_pending', 'member_type4' => 'application_rejected', 'id_project' => $id_project, 'id_user' => $id_invited_user]);

        if(!$st->fetch())
        {
            $st = $db->prepare('INSERT INTO dz2_members (id_project, id_user, member_type) VALUES (:id_project, :id_user, :member_type)');
            $st->execute(['id_project' => $id_project, 'id_user' => $id_invited_user,  'member_type' => 'invitation_pending']);
            return True;
        }
        else
        {
            return False;
        }
    }

    public static function getProjectApplicationsByID($id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('SELECT * FROM dz2_members WHERE id_project=:id_project');
        $st->execute(['id_project' => $id_project]);
        
        $applications = [];
        while($row = $st->fetch())
        {
            if($row['member_type'] === 'application_pending')
                $applications[] = [new Member($row['id'], $row['id_project'], $row['id_user'], $row['member_type']), TeamUpService::getUserByID($row['id_user'])];
        }

        return $applications;
    }

    public static function acceptApplication($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('UPDATE dz2_members SET member_type=:member_type WHERE id_project=:id_project AND id_user=:id_user');

        echo $st->execute(['member_type' => 'application_accepted', 'id_project' => $id_project, 'id_user' => $id_user]);
    }

    public static function rejectApplication($id_user, $id_project)
    {
        $db = DB::getConnection();
        $st = $db->prepare('UPDATE dz2_members SET member_type=:member_type WHERE id_project=:id_project AND id_user=:id_user');
        $st->execute(['member_type' => 'application_rejected', 'id_project' => $id_project, 'id_user' => $id_user]);
    }

    public static function processLogout()
    {
        if(isset($_SESSION))
        {
            session_unset();
            session_destroy();
        }
    }

    // public static function getAllUsers()
    // {
    //     $users = [];
    //     $db = DB::getConnection();

    //     $st = $db->prepare('SELECT * FROM users');

    //     $st->execute([]);

    //     while($row = $st->fetch())
    //     {
    //         $user = new User($row['id'], $row['name'], $row['surname'], $row['password']);
    //         $users[] = $user;
    //     }

    //     return $users;
    // }

    public static function getAllProjects()
    {
        $projects = [];
        $users = [];
        $db = DB::getConnection();

        $st = $db->prepare('SELECT * FROM dz2_projects');

        $st->execute([]);

        while($row = $st->fetch())
        {
            $project = new Project($row['id'], $row['id_user'], $row['title'], $row['abstract'], $row['number_of_members'], $row['status']);
            $username = TeamUpService::getUserByID($row['id_user'])->username;
            $projects[] = [$project, $username];
        }

        return $projects;
    }

    public static function processLogin()
    {
        // Provjeri sastoji li se ime samo od slova; ako ne, crtaj login formu.
		if( !isset( $_POST['username'] ) || !isset($_POST['password']) || !preg_match( '/^[a-zA-Z ,-.]+$/', $_POST['username'] ) )
		{
            require_once __DIR__ . '/../view/login_index.php';
			return False;
		}
        

        // return TeamUpService::getAllProjects();

		// require_once __DIR__ . '/../view/projects_index.php';

        // Sve je OK, provjeri jel ga ima u bazi.
        $db = DB::getConnection();

        try
        {
            $st = $db->prepare( 'SELECT * FROM dz2_users WHERE username=:username' );
            $st->execute( array( 'username' => $_POST["username"] ) );
        }
        catch( PDOException $e ) { require_once __DIR__ . '/../view/login_index.php'; return False; }

        $row = $st->fetch();

        if( $row === false )
        {
            // Taj user ne postoji, upit u bazu nije vratio ništa.
            require_once __DIR__ . '/../view/login_index.php';
            return False;
        }
        else
        {
            
            // Postoji user. Dohvati hash njegovog passworda.
            $hash = $row[ 'password_hash'];
            $id_user = $row['id'];
            // Da li je password dobar?
            if( password_verify( $_POST['password'], $hash ) )
            {
                // Dobar je. Ulogiraj ga.
                //crtaj_uspjesnoUlogiran( $_POST['username' ] );
                $_SESSION['login'] = $_POST['username'] . ',' . $hash . ',' . $id_user;
                $_SESSION['username'] = $_POST['username'];
                // require_once __DIR__ . '/../teamup.php?rt=projects/index';//&id_user=' . $id_user;
                return TeamUpService::getAllProjects();/*?rt=products/index*/
            }
            else
            {
                // Nije dobar. Crtaj opet login formu s pripadnom porukom.
                require_once __DIR__ . '/../view/login_index.php';
                return False;
            }
        }
        // return TeamUpService::getAllProjects();
    }

    // public static function getBooksByAuthor($author)
    // {
    //     $books = [];
    //     $db = DB::getConnection();

    //     $st = $db->prepare('SELECT * FROM books WHERE author=:author');

    //     $st->execute(['author' => $author]);

    //     while($row = $st->fetch())
    //     {
    //         $book = new Book($row['id'], $row['author'], $row['title']);
    //         $books[] = $book;
    //     }

    //     return $books;
    // }
}

?>