<?php
require 'db.php';

$melding = '';

// hent klasser til listeboksen
$klasser = $pdo->query("SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brukernavn = trim($_POST['brukernavn'] ?? '');
    $fornavn    = trim($_POST['fornavn'] ?? '');
    $etternavn  = trim($_POST['etternavn'] ?? '');
    $klassekode = trim($_POST['klassekode'] ?? '');

    if ($brukernavn === '' || $fornavn === '' || $etternavn === '' || $klassekode === '') {
        $melding = 'Alle felt må fylles ut.';
    } else {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO student (brukernavn, fornavn, etternavn, klassekode)
                 VALUES (:bn, :fn, :en, :kk)"
            );
            $stmt->execute([
                ':bn' => $brukernavn,
                ':fn' => $fornavn,
                ':en' => $etternavn,
                ':kk' => $klassekode,
            ]);
            $melding = 'Student registrert!';
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                // enten brukernavn finnes allerede, eller klassekode finnes ikke (FK)
                $melding = 'Feil: Brukernavn finnes allerede, eller klassekode er ugyldig.';
            } else {
                $melding = 'Databasefeil: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!doctype html>
<html lang="no">
<head><meta charset="utf-8"><title>Registrer student</title></head>
<body>
  <h1>Registrer student</h1>
  <p><a href="index.php">Til meny</a></p>

  <?php if ($melding): ?>
    <p><strong><?php echo htmlspecialchars($melding); ?></strong></p>
  <?php endif; ?>

  <?php if (!$klasser): ?>
    <p>Du må først registrere en <a href="klasse_create.php">klasse</a>.</p>
  <?php else: ?>
    <form method="post">
      <label>Brukernavn (maks 7 tegn):
        <input type="text" name="brukernavn" maxlength="7" required>
      </label><br><br>
      <label>Fornavn:
        <input type="text" name="fornavn" required>
      </label><br><br>
      <label>Etternavn:
        <input type="text" name="etternavn" required>
      </label><br><br>
      <label>Klassekode:
        <select name="klassekode" required>
          <option value="">-- velg --</option>
          <?php foreach ($klasser as $k): ?>
            <option value="<?php echo htmlspecialchars($k['klassekode']); ?>">
              <?php echo htmlspecialchars($k['klassekode'] . ' – ' . $k['klassenavn']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label><br><br>
      <button type="submit">Lagre</button>
    </form>
  <?php endif; ?>
</body>
</html>
