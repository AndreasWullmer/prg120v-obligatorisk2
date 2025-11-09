<?php
require 'storage.php';

$msg = '';
$klasser = klasse_all();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['klasse_id'] ?? 0);
    if ($id > 0) {
        [$ok, $msg] = klasse_delete($id); // blokkerer automatisk hvis studenter finnes
        if ($ok) {
            $msg = "Klasse med ID $id er slettet.";
        } else {
            // beholder $msg fra storage.php, f.eks. "Kan ikke slette: klassen har studenter."
        }
    } else {
        $msg = "Velg en klasse.";
    }
    // oppdater listen etter sletting
    $klasser = klasse_all();
}
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Slett klasse</title></head>
<body>
  <h1>Slett klasse</h1>

  <?php if ($msg): ?>
    <p><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <?php if (!$klasser): ?>
    <p>Ingen klasser å slette.</p>
  <?php else: ?>
    <form method="post" onsubmit="return confirm('Er du sikker på at du vil slette denne klassen?');">
      <label>Velg klasse:
        <select name="klasse_id" required>
          <option value="">(velg)</option>
          <?php foreach ($klasser as $k): ?>
            <option value="<?= (int)$k['id'] ?>">
              <?= (int)$k['id'] ?> – <?= htmlspecialchars($k['kode'].' / '.$k['navn']) ?>
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
