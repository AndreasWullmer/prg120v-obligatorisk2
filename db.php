<?php
$host = 'b-studentsql-1';
$port = 3306;
$db   = 'anwul4724';
$user = 'anwul4724';
$pass = '4430anwul4724';

$mysqli = new mysqli($host, $user, $pass, $db, $port);

if ($mysqli->connect_errno) {
    die("DB-tilkobling feilet: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4");
