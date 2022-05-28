<?php require_once __DIR__ . '/_header.php'; ?>

<table>
    <?php
        if($application_successfull)
        {
            echo 'Application submitted successfully!';
        }
        else{
            echo 'Application not submitted successfully!';
        }

        echo '</br>';

        if($title === 'Application status')
            echo '<form action="teamup.php?rt=projects/show&id_project=' . $project_current->id . '" method="POST">' .
                '<button type="submit">Take me back!</button>' .
                    '</form>';
    ?>
</table>

<?php require_once __DIR__ . '/_footer.php'; ?>