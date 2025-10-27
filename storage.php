<?php
// Bruk systemets temp-mappe (skrivbar i Dokploy)
define('DATA_DIR', sys_get_temp_dir() . '/prg120v-data');

// Lag mappa hvis den ikke finnes
if (!is_dir(DATA_DIR)) {
    mkdir(DATA_DIR, 0777, true);
}

// --------- Hjelpefunksjoner ----------
function path_for($name) {
    return DATA_DIR . "/$name.json";
}

function load_json($name) {
    $file = path_for($name);
    if (!file_exists($file)) return [];
    $raw = file_get_contents($file);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function save_json($name, array $data) {
    $file = path_for($name);
    // Skriv pent formaterte JSON-data med lås
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $fp = fopen($file, 'c+');
    if (!$fp) die("Kunne ikke åpne $file for skriving.");
    if (!flock($fp, LOCK_EX)) die("Kunne ikke låse $file.");
    ftruncate($fp, 0);
    fwrite($fp, $json);
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
}

function next_id(array $rows) {
    $max = 0;
    foreach ($rows as $r) {
        if (isset($r['id']) && $r['id'] > $max) $max = (int)$r['id'];
    }
    return $max + 1;
}

// --------- KLASSER ----------
function klasse_all() {
    return load_json('klasse');
}

function klasse_create($navn) {
    $rows = klasse_all();
    $rows[] = ['id' => next_id($rows), 'navn' => (string)$navn];
    save_json('klasse', $rows);
}

function klasse_delete($id) {
    $id = (int)$id;
    $rows = klasse_all();
    $rows = array_values(array_filter($rows, fn($r) => (int)$r['id'] !== $id));
    save_json('klasse', $rows);

    // Når en klasse slettes, sett studentenes klasse_id til null
    $students = student_all();
    foreach ($students as &$s) {
        if ((int)($s['klasse_id'] ?? 0) === $id) {
            $s['klasse_id'] = null;
        }
    }
    save_json('student', $students);
}

// --------- STUDENTER ----------
function student_all() {
    return load_json('student');
}

function student_create($navn, $klasse_id = null) {
    $rows = student_all();
    $rows[] = [
        'id' => next_id($rows),
        'navn' => (string)$navn,
        'klasse_id' => $klasse_id !== '' ? (is_null($klasse_id) ? null : (int)$klasse_id) : null
    ];
    save_json('student', $rows);
}

function student_delete($id) {
    $id = (int)$id;
    $rows = student_all();
    $rows = array_values(array_filter($rows, fn($r) => (int)$r['id'] !== $id));
    save_json('student', $rows);
}
