<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <tr>
        <th>Author</th><th>Project name</th><th>Status</th>
    </tr>
    <?php
        if(!empty($projects))
            foreach($projects as $project)
            {
                echo '<table><tr>';
                echo '<td>' . $project[1]->username . '</td>';
                echo '<td>' . $project[0]->title . '</td>';
                echo '<td>' . $project[0]->status . '</td>';
                echo '<td>' . $project[2] . '</td>';
                echo '</tr></table>';

                if($project[0]->status === 'open' && $project[2] === 'invitation_pending')
                {
                    echo '<div>';
                    echo '<form action="teamup.php?rt=invitations/decision&id_project=' . $project[0]->id . '" method="POST">' .
                        '<button type="submit" name="accept">Accept invitation!</button></br>' .
                        '<button type="submit" name="reject">Reject invitation!</button></br>' .
                        '</form>';
                    echo '</div>';
                }
            }
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>