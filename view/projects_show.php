<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Project name</th><th>Author</th><th>Description</th><th>Status</th><th>Target number of members</th>
    </tr>
    <?php
        echo '<table>';
        foreach($projectlist as $project)
        {
            echo '<tr>';
            echo '<td>' . $project[0]->title . '</td>';
            echo '<td>' . $project[1] . '</td>';
            echo '<td>' . $project[0]->abstract . '</td>';
            echo '<td>' . $project[0]->status . '</td>';
            echo '<td>' . $project[0]->number_of_members . '</td>';
            echo '<td>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table></br></br>';
        echo '<b>List of members:</b></br>';
        echo '<div>';
        foreach($memberlist as $member)
        {
            echo $member->username . ' ';
        }
        echo '</div>';

        if(!$member_already)
        {
            echo '<form action="teamup.php?rt=projects/apply&id_project=' . $project[0]->id . '" method="POST">' .
            '<button type="submit">Apply!</button>' .
                '</form>';
        }
        // application list vjv uopce ne treba
        if($project[0]->status === 'open')
        {
            foreach($applicationlist as $application)
            {
                echo '<div>';
                echo $application[1]->username . ' wants to apply!';
                echo '<form action="teamup.php?rt=projects/decision&id_project=' . $project[0]->id . '" method="POST">' .
                    '<input type="text" name="id_user" value="' . $application[0]->id_user . '" hidden readonly>' .
                    '<button type="submit" name="accept">Accept application!</button></br>' .
                    '<button type="submit" name="reject">Reject application!</button></br>' .
                    '</form>';
                echo '</div>';
            }
        }

        if($project[0]->status === 'open' && $iAmAuthor)
        {
            echo '<form action="teamup.php?rt=projects/invite&id_project=' . $project[0]->id . '" method="POST">' .
            '<input type="text" name="person_to_invite">' .
            '<button type="submit">Invite!</button>' .
                '</form>';
        }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>