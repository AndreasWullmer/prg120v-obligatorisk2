<?php
require 'storage.php';
$studenter = student_all();
$klasser = [];
foreach (klasse_all() as $k) { $klasser[$k['id']] = $k['navn']; }
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Alle studenter</title></head>
<body>
  <h1>Alle studenter</h1>
  <?php if (!$studenter): ?>
    <p>Ingen studenter registrert ennå.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($studenter as $s): ?>
        <li>
          ID <?= (int)$s['id'] ?> – <?= htmlspecialchars($s['navn']) ?>
          (klasse <?= isset($s['klasse_id']) && $s['klasse_id'] !== null ? htmlspecialchars($klasser[$s['klasse_id']] ?? ('ID '.$s['klasse_id'])) : 'ingen' ?>)
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
