<?php
// db.php – enkel databasekobling med PDO (XAMPP-standard: root uten passord)

$DB_HOST = 'localhost';
$DB_NAME = 'prg120v';   // databasen du laget i phpMyAdmin
$DB_USER = 'root';      // XAMPP default
$DB_PASS = '';          // tomt passord som standard i XAMPP
$DSN     = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // få tydelig feilmelding ved feil
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($DSN, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    exit('Database-tilkobling feilet: ' . htmlspecialchars($e->getMessage()));
}
