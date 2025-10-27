<?php
require 'db.php';
$sql = "SELECT s.brukernavn, s.fornavn, s.etternavn, s.klassekode, k.klassenavn
        FROM student s
        JOIN klasse k ON k.klassekode = s.klassekode
        ORDER BY s.brukernavn";
$studenter = $pdo->query($sql)->fetchAll();
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Alle studenter</title></head>
<body>
  <h1>Alle studenter</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if (!$studenter): ?>
    <p>Ingen studenter registrert.</p>
  <?php else: ?>
    <table border="1" cellpadding="5" cellspacing="0">
      <tr>
        <th>Brukernavn</th><th>Fornavn</th><th>Etternavn</th><th>Klassekode</th><th>Klassenavn</th>
      </tr>
      <?php foreach ($studenter as $s): ?>
        <tr>
          <td><?php echo htmlspecialchars($s['brukernavn']); ?></td>
          <td><?php echo htmlspecialchars($s['fornavn']); ?></td>
          <td><?php echo htmlspecialchars($s['etternavn']); ?></td>
          <td><?php echo htmlspecialchars($s['klassekode']); ?></td>
          <td><?php echo htmlspecialchars($s['klassenavn']); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
</body>
</html>
