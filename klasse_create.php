<?php
require 'db.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klassekode = trim($_POST['klassekode'] ?? '');
    $klassenavn = trim($_POST['klassenavn'] ?? '');
    $studiumkode = trim($_POST['studiumkode'] ?? '');

    if ($klassekode === '' || $klassenavn === '' || $studiumkode === '') {
        $melding = 'Alle felt må fylles ut.';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO klasse (klassekode, klassenavn, studiumkode)
                 VALUES (:k, :n, :s)"
            );
            $stmt->execute([
                ':k' => $klassekode,
                ':n' => $klassenavn,
                ':s' => $studiumkode,
            ]);
            $melding = 'Klasse registrert!';
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $melding = 'Feil: Klassekode finnes allerede.';
            } else {
                $melding = 'Databasefeil: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Registrer klasse</title></head>
<body>
  <h1>Registrer klasse</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if ($melding): ?>
    <p><strong><?php echo htmlspecialchars($melding); ?></strong></p>
  <?php endif; ?>

  <form method="post">
    <label>Klassekode (maks 5 tegn):
      <input type="text" name="klassekode" maxlength="5" required>
    </label><br><br>
    <label>Klassenavn:
      <input type="text" name="klassenavn" required>
    </label><br><br>
    <label>Studiumkode:
      <input type="text" name="studiumkode" required>
    </label><br><br>
    <button type="submit">Lagre</button>
  </form>
</body>
</html>
