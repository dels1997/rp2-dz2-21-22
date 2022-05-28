<!DOCTYPE html>
<html>
<head>
    <title>TeamUp</title>
    <link rel="stylesheet" href="<?php echo __SITE_URL;?>/css/style.css">
</head>
<body>
    <h1>TeamUp</h1>
    <ul>
        <li>
        <a href="teamup.php?rt=projects/index">All projects</a>
        </li>
        <li>
        <a href="teamup.php?rt=projects/owned">My projects</a>
        </li>
        <li>
        <a href="teamup.php?rt=invitations/index">Pending invitations</a>
        </li>
        <li>
        <a href="teamup.php?rt=applications/index">Pending applications</a>
        </li>
        <li>
        <a href="teamup.php?rt=logout/index">Logout</a>
        </li>
    </ul>

    <h2>
        <?php echo $title; ?>
    </h2>