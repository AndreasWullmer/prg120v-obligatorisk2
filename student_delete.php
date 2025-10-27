<?php
require 'db.php';

$melding = '';

// hent studenter til listeboksen
$studenter = $pdo->query("SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brukernavn = $_POST['brukernavn'] ?? '';
    if ($brukernavn === '') {
        $melding = 'Velg en student.';
    } else {
        $stmt = $pdo->prepare("DELETE FROM student WHERE brukernavn = :bn");
        $stmt->execute([':bn' => $brukernavn]);
        $melding = $stmt->rowCount() > 0
            ? "Student '$brukernavn' er slettet."
            : "Fant ingen student med brukernavn '$brukernavn'.";
        // oppdater lista etter sletting
        $studenter = $pdo->query("SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn")->fetchAll();
    }
}
?>
<!doctype html>
<html lang="no">
<head>
  <meta charset="utf-8"><title>Slett student</title>
  <script>
    function bekreftSletting() {
      return confirm('Er du sikker på at du vil slette denne studenten?');
    }
  </script>
</head>
<body>
  <h1>Slett student</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if ($melding): ?>
    <p><strong><?php echo htmlspecialchars($melding); ?></strong></p>
  <?php endif; ?>

  <?php if (!$studenter): ?>
    <p>Ingen studenter å slette.</p>
  <?php else: ?>
    <form method="post" onsubmit="return bekreftSletting();">
      <label>Velg student (brukernavn):
        <select name="brukernavn" required>
          <option value="">-- velg --</option>
          <?php foreach ($studenter as $s): ?>
            <option value="<?php echo htmlspecialchars($s['brukernavn']); ?>">
              <?php echo htmlspecialchars($s['brukernavn'] . ' – ' . $s['fornavn'] . ' ' . $s['etternavn']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit">Slett</button>
    </form>
  <?php endif; ?>
</body>
</html>
