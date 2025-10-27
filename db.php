<?php
die("TEST-MARKØR");
// --- Verdier fra Dokploy ---
$host = 'mysql-12.dokploy.usn.no';
$port = 3306;
$db   = 'anwul4724';
$user = 'anwul4724';
$pass = '4430anwul4724';

// --- Koble til med mysqli ---
$mysqli = new mysqli($host, $user, $pass, $db, $port);

// Sjekk om det oppstår feil ved tilkobling
if ($mysqli->connect_errno) {
    die("DB-tilkobling feilet: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// Sørg for riktig tegnsett (æøå osv.)
$mysqli->set_charset("utf8mb4");
