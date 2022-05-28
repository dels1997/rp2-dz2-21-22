<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <?php
        if($application_accepted)
        {
            echo 'Application accepted successfully!';
        }
        else{
            echo 'Application rejected successfully!';
        }

        echo '</br>';

        if($title === 'Application status')
            echo '<form action="teamup.php?rt=projects/show&id_project=' . $id_project . '" method="POST">' .
                '<button type="submit">Take me back!</button>' .
                    '</form>';
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>