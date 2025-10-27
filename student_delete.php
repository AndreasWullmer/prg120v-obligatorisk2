<?php
require 'storage.php';

// Hvis du klikker en "Slett"-lenke med ?id=...
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    student_delete($id);
    $msg = "Student med ID $id er slettet.";
}

// Hent alle studenter for å vise liste med slett-lenker
$studenter = student_all();
$klasser = [];
foreach (klasse_all() as $k) { $klasser[$k['id']] = $k['navn']; }
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Slett student</title></head>
<body>
  <h1>Slett student</h1>

  <?php if (!empty($msg)): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <?php if (!$studenter): ?>
    <p>Ingen studenter å slette.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($studenter as $s): ?>
        <li>
          <?= (int)$s['id'] ?> – <?= htmlspecialchars($s['navn']) ?>
          (klasse <?= isset($s['klasse_id']) && $s['klasse_id'] !== null ? htmlspecialchars($klasser[$s['klasse_id']] ?? ('ID '.$s['klasse_id'])) : 'ingen' ?>)
          – <a href="?id=<?= (int)$s['id'] ?>">Slett</a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
