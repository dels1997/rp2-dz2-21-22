<?php

require_once __DIR__ . '/../../model/user.class.php';

$userlist = [];
$userlist[] = new User(1, 'Mirko', 'Mirić', password_hash('mirkovasifra', PASSWORD_DEFAULT));
$userlist[] = new User(1, 'Ana', 'Anić', password_hash('aninasifra', PASSWORD_DEFAULT));
$userlist[] = new User(1, 'Maja', 'Majić', password_hash('majinasifra', PASSWORD_DEFAULT));

$title = 'Popis svih korisnika';

require_once __DIR__ . '/../../view/users_index.php';

?>