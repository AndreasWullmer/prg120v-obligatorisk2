<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php'; // denne skal opprette $pdo

try {
    // Enkel sjekk: koble og spør MySQL-versjon
    $stmt = $pdo->query('SELECT VERSION() AS v');
    $row = $stmt->fetch();
    echo "DB-tilkobling OK. MySQL-versjon: " . ($row['v'] ?? 'ukjent');
} catch (Throwable $e) {
    echo "FEIL: " . $e->getMessage();
}
