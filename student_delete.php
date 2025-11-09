<?php
require 'storage.php';

$msg = '';
$studenter = student_all();
$klasser = [];
foreach (klasse_all() as $k) { $klasser[$k['id']] = $k['kode'].' – '.$k['navn']; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['student_id'] ?? 0);
    if ($id > 0) {
        [$ok, $msg] = student_delete($id);
        if ($ok) $msg = "Student med ID $id er slettet.";
    } else {
        $msg = "Velg en student.";
    }
    // oppdater listen etter sletting
    $studenter = student_all();
}
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Slett student</title></head>
<body>
  <h1>Slett student</h1>

  <?php if ($msg): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <?php if (!$studenter): ?>
    <p>Ingen studenter å slette.</p>
  <?php else: ?>
    <form method="post" onsubmit="return confirm('Er du sikker på at du vil slette denne studenten?');">
      <label>Velg student:
        <select name="student_id" required>
          <option value="">(velg)</option>
          <?php foreach ($studenter as $s): ?>
            <option value="<?= (int)$s['id'] ?>">
              <?= (int)$s['id'] ?> – <?= htmlspecialchars($s['brukernavn'].' / '.$s['navn']) ?>
              <?php if ($s['klasse_id'] !== null): ?>
                (<?= htmlspecialchars($klasser[$s['klasse_id']] ?? ('ID '.$s['klasse_id'])) ?>)
              <?php else: ?>
                (ingen klasse)
              <?php endif; ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit">Slett</button>
    </form>
  <?php endif; ?>

  <p><a href="index.php">Tilbake til meny</a></p>
</body>
</html>
