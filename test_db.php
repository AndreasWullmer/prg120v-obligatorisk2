<?php
require 'db.php';

// prøv en enkel spørring: hent tabellnavn
$tables = $pdo->query("SHOW TABLES")->fetchAll();

echo "<h1>DB-test</h1>";
echo "<p>Kobling OK ✅</p>";

if (!$tables) {
    echo "<p>Fant ingen tabeller.</p>";
} else {
    echo "<p>Tabeller i databasen:</p><ul>";
    foreach ($tables as $row) {
        // raden har nøkkel 0 med tabellnavn
        echo "<li>" . htmlspecialchars($row[array_key_first($row)]) . "</li>";
    }
    echo "</ul>";
}

echo '<p><a href="index.php">Til start</a></p>';
