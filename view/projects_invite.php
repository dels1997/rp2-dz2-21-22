<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <?php
        if($invitation_successfull)
        {
            echo 'Invitation submitted successfully!';
        }
        else{
            echo 'Invitation not submitted successfully!';
        }

        echo '</br>';

        if($title === 'Invitation status')
            echo '<form action="teamup.php?rt=projects/show&id_project=' . $id_project . '" method="POST">' .
                '<button type="submit">Take me back!</button>' .
                    '</form>';
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>