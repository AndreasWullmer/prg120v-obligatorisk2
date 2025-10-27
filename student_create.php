<?php
require 'storage.php';

$msg = '';
$klasser = klasse_all();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $navn = trim($_POST['navn'] ?? '');
    $klasse_id = $_POST['klasse_id'] ?? ''; // tom streng = ingen klasse

    if ($navn === '') {
        $msg = 'Skriv inn navn.';
    } else {
        // lagre
        student_create($navn, $klasse_id === '' ? null : (int)$klasse_id);
        $msg = 'Studenten ble lagret.';
    }
}
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8">
  <title>Registrer student</title>
</head>
<body>
  <h1>Registrer student</h1>

  <?php if ($msg): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <form method="post">
    <div>
      <label>Navn:
        <input type="text" name="navn" required>
      </label>
    </div>

    <div>
      <label>Klasse (valgfritt):
        <select name="klasse_id">
          <option value="">(ingen)</option>
          <?php foreach ($klasser as $k): ?>
            <option value="<?= (int)$k['id'] ?>"><?= htmlspecialchars($k['navn']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>

    <button type="submit">Lagre</button>
  </form>

  <p><a href="student_list.php">Vis alle studenter</a></p>
  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
