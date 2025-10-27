<?php
require 'storage.php';

klasse_create("Testklasse A");
student_create("Ola Nordmann", 1);

echo "<h3>Klasser</h3>";
foreach (klasse_all() as $k) {
    echo $k['id'] . " – " . htmlspecialchars($k['navn']) . "<br>";
}

echo "<h3>Studenter</h3>";
foreach (student_all() as $s) {
    echo $s['id'] . " – " . htmlspecialchars($s['navn']) .
         " (klasse " . ($s['klasse_id'] ?? 'ingen') . ")<br>";
}
