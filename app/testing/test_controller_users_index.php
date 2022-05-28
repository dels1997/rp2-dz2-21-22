<?php

require_once __DIR__ . '/../../controller/users_controller.php';

$con = new UsersController();
$con->index();

?>