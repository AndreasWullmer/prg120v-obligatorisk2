<?php
require 'storage.php';
$klasser = klasse_all();
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8">
  <title>Alle klasser</title>
</head>
<body>
  <h1>Alle klasser</h1>
  <?php if (!$klasser): ?>
    <p>Ingen klasser registrert ennå.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($klasser as $k): ?>
        <li>
          ID <?= (int)$k['id'] ?> – <?= htmlspecialchars($k['navn']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
