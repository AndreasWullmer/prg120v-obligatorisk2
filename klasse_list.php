<?php
require 'db.php';
$klasser = $pdo->query("SELECT klassekode, klassenavn, studiumkode FROM klasse ORDER BY klassekode")->fetchAll();
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Alle klasser</title></head>
<body>
  <h1>Alle klasser</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if (!$klasser): ?>
    <p>Ingen klasser registrert.</p>
  <?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
      <tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>
      <?php foreach ($klasser as $k): ?>
        <tr>
          <td><?php echo htmlspecialchars($k['klassekode']); ?></td>
          <td><?php echo htmlspecialchars($k['klassenavn']); ?></td>
          <td><?php echo htmlspecialchars($k['studiumkode']); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</body>
</html>
