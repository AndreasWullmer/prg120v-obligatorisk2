<?php
require 'storage.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $navn = trim($_POST['navn'] ?? '');
    if ($navn === '') {
        $msg = 'Skriv inn et navn.';
    } else {
        klasse_create($navn);
        $msg = 'Klassen ble lagret.';
    }
}
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8">
  <title>Registrer klasse</title>
</head>
<body>
  <h1>Registrer klasse</h1>

  <?php if ($msg): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <form method="post">
    <label>
      Klassenavn:
      <input type="text" name="navn" required>
    </label>
    <button type="submit">Lagre</button>
  </form>

  <p><a href="klasse_list.php">Vis alle klasser</a></p>
  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
