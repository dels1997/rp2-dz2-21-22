<?php require_once __DIR__ . '/_header.php'; ?>

<?php
    echo '<form action="teamup.php?rt=start/create" method="POST">' .
        'Project title: </br>' .
        '<input type="text" name="title" maxlength="50" minlength="1" required></br>' .
        'Project abstract: </br>' .
        '<input type="text" name="abstract" maxlength="1000" minlength="1" required></br>' .
        'Number of allowed project members: </br>' .
        '<input type="text" name="number_of_members" maxlength="11" minlength="1" required></br>' .
        '<button type="submit">Create!</button>' .
        '</form>';
?>

<?php require_once __DIR__ . '/_footer.php'; ?>