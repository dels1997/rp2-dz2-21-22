<?php
require_once __DIR__ . '/../../model/user.class.php';
require_once __DIR__ . '/../../model/libraryservice.class.php';

$users = LibraryService::getAllUsers();

echo '<pre>';
print_r($users);
echo '</pre>';
?>