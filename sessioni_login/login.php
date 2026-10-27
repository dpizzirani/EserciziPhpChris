<?php
// Avvio la sessione
session_start();

// Controllo se ho già fatto il login in precedenza e nel caso lo redireziono
// all'area riservata
if (isset($_SESSION['logged']) && $_SESSION['logged']===1)
    header('Location: area_riservata.php');

// Inizializzazione variabili e array errori
$username = "";
$password = "";
$errori = [];

$utenti = [
    "mario" => "nonlaso778",
    "anna" => "altra_pwd123",
    "luca" => "ufh5cj456"
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Tre uguali sono uguale con stesso tipo di dato
    // Recupero dati con rimozione spazi
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // 3. Validazione lato server
    if ($username === '') {
        $errori['username'] = "Inserire lo username.";
    }
    if ($password === '') {
        $errori['password'] = "Inserire la password.";
    }

    // Controllo se esiste l'utente solamente se ho inserito username e password
    if (empty($errori)) {
        if ($utenti[$username] === $password) {
            $_SESSION['logged'] = 1;
            $_SESSION['username'] = $username;
            header('Location: area_riservata.php');
        }
        else {
            $errori['loginErrato'] = "Login errato, controllare username e password";
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style>
        body { font-family: sans-serif; max-width: 500px; margin: 40px auto; padding: 0 20px; }
        .campo { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        .bordo-errore { border: 1px solid #d9534f; }
        .errore-testo { color: #d9534f; font-size: 0.85em; margin-top: 4px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
	</style>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($errori['loginErrato'])): ?>
        <div class="alert-danger">
            <?= $errori['loginErrato'] ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="campo">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"
                   value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                   class="<?= isset($errori['username']) ? 'bordo-errore' : '' ?>">
            <?php if (isset($errori['username'])): ?>
                <div class="errore-testo"><?= htmlspecialchars($errori['username']) ?></div>
            <?php endif; ?>
        </div>
        <div class="campo">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"
                   value="<?= htmlspecialchars($password, ENT_QUOTES, 'UTF-8') ?>"
                   class="<?= isset($errori['password']) ? 'bordo-errore' : '' ?>">
            <?php if (isset($errori['password'])): ?>
                <div class="errore-testo"><?= htmlspecialchars($errori['password']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Invia Dati</button>
    </form>
</body>
</html>
