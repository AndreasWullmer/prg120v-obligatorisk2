<?php
echo "<!doctype html>";
echo '<html lang="no">';
echo "<head><meta charset='utf-8'><title>PRG120V – meny</title></head>";
echo "<hr><p>Deploy-markør: v1 — ".date('Y-m-d H:i:s')."</p>";
echo '<p><a href="phpinfo.php">Åpne PHP-info</a></p>';
echo "<body>";
echo "<h1>PRG120V – meny</h1>";

echo "<h2>Klasse</h2><ul>";
echo '<li><a href="klasse_create.php">Registrer klasse</a></li>';
echo '<li><a href="klasse_list.php">Vis alle klasser</a></li>';
echo '<li><a href="klasse_delete.php">Slett klasse</a></li>';
echo "</ul>";

echo "<h2>Student</h2><ul>";
echo '<li><a href="student_create.php">Registrer student</a></li>';
echo '<li><a href="student_list.php">Vis alle studenter</a></li>';
echo '<li><a href="student_delete.php">Slett student</a></li>';
echo "</ul>";

echo '<p><a href="test_db.php">Test database-tilkobling</a></p>';
echo "</body></html>";
?>
