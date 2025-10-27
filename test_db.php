<?php
require 'db.php';

$res = $sqlite->query("SELECT name FROM sqlite_master WHERE type='table'");
$tables = [];
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $tables[] = $row['name'];
}

echo "SQLite virker! Tabeller funnet: " . implode(', ', $tables);
