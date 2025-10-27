<?php
require 'storage.php';

// Hvis du trykker på "Slett", kommer ?id= i lenken:
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    klasse_delete($id);
    $msg = "Klasse med ID $id er slettet.";
}

// Hent alle klasser (for å vise valg)
$klasser = klasse_all();
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8">
  <title>Slett klasse</title>
</head>
<body>
  <h1>Slett klasse</h1>

  <?php if (!empty($msg)): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <?php if (!$klasser): ?>
    <p>Ingen klasser å slette.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($klasser as $k): ?>
        <li>
          <?= htmlspecialchars($k['navn']) ?>
          – <a href="?id=<?= (int)$k['id'] ?>">Slett</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
