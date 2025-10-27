<?php
// SQLite – lokal databasefil i data/app.db
$dbPath = __DIR__ . '/data/app.db';

class DB extends SQLite3 {
    function __construct($path) {
        $this->open($path);
    }
}

$sqlite = new DB($dbPath);
if (!$sqlite) {
    die("Kunne ikke åpne SQLite: " . $sqlite->lastErrorMsg());
}

// Slå på foreign keys
$sqlite->exec('PRAGMA foreign_keys = ON;');

// Opprett tabeller hvis de ikke finnes
$sqlite->exec("
CREATE TABLE IF NOT EXISTS klasse (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    navn TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS student (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    navn TEXT NOT NULL,
    klasse_id INTEGER,
    FOREIGN KEY (klasse_id) REFERENCES klasse(id) ON DELETE SET NULL
);
");
