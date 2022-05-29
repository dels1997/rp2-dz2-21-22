<?php require_once __DIR__ . '/_header.php'; ?>

<?php
    if($creation_successfull)
    {
        echo 'Creation was successfull!';
    }
    else
    {
        echo 'Creation was not successfull!';
    }

    if($title === 'Creation status')
            echo '<form action="teamup.php?rt=start/index" method="POST">' .
                '<button type="submit">Take me back!</button>' .
                    '</form>';
?>

<?php require_once __DIR__ . '/_footer.php'; ?>