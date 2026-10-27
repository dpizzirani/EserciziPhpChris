<?php
session_start();

$_SESSION['logged'] = 0;
$_SESSION['username'] = '';

header('Location: login.php');

?>
