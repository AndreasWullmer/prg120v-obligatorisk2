<?php
require 'db.php';

$melding = '';

// hent klasser til listeboksen
$klasser = $pdo->query("SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['klassekode'] ?? '';
    if ($kode === '') {
        $melding = 'Velg en klasse.';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM klasse WHERE klassekode = :k");
            $stmt->execute([':k' => $kode]);
            $melding = $stmt->rowCount() > 0
                ? "Klasse '$kode' er slettet."
                : "Fant ingen klasse med kode '$kode'.";
        } catch (PDOException $e) {
            // 23000 = brudd på FK (klassen har studenter)
            if ($e->getCode() === '23000') {
                $melding = "Kan ikke slette: Klassen har studenter tilknyttet.";
            } else {
                $melding = 'Databasefeil: ' . htmlspecialchars($e->getMessage());
            }
        }
        // oppdater lista etter forsøk på slett
        $klasser = $pdo->query("SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode")->fetchAll();
    }
}
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8"><title>Slett klasse</title>
  <script>
    function bekreftSletting() {
      return confirm('Er du sikker på at du vil slette denne klassen?');
    }
  </script>
</head>
<body>
  <h1>Slett klasse</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if ($melding): ?>
    <p><strong><?php echo htmlspecialchars($melding); ?></strong></p>
  <?php endif; ?>

  <?php if (!$klasser): ?>
    <p>Ingen klasser å slette.</p>
  <?php else: ?>
    <form method="post" onsubmit="return bekreftSletting();">
      <label>Velg klasse:
        <select name="klassekode" required>
          <option value="">-- velg --</option>
          <?php foreach ($klasser as $k): ?>
            <option value="<?php echo htmlspecialchars($k['klassekode']); ?>">
              <?php echo htmlspecialchars($k['klassekode'] . ' – ' . $k['klassenavn']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit">Slett</button>
    </form>
  <?php endif; ?>
</body>
</html>
