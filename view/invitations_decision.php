<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <?php
        if($invitation_accepted)
        {
            echo 'Invitation accepted successfully!';
        }
        else{
            echo 'Invitation rejected successfully!';
        }

        echo '</br>';

        if($title === 'Invitation status')
            echo '<form action="teamup.php?rt=invitations/index" method="POST">' .
                '<button type="submit">Take me back!</button>' .
                    '</form>';
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>