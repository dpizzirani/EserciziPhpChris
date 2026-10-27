<?php
session_start();

// Controllo che l'utente abbia fatto il login
if (!isset($_SESSION['logged']) || $_SESSION['logged']==0)
    header('Location: login.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Area Riservata</title>
</head>
<body>
    <h2> Benvenuto <?= $_SESSION['username'] ?> </h2>

    <a href="logout.php"> Logout </a>
</body>
</html>
