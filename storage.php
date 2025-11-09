<?php
// Bruk systemets temp-mappe (skrivbar i Dokploy)
define('DATA_DIR', sys_get_temp_dir() . '/prg120v-data');
if (!is_dir(DATA_DIR)) { mkdir(DATA_DIR, 0777, true); }

// ---------- Hjelp ----------
function path_for($name) { return DATA_DIR . "/$name.json"; }
function load_json($name) {
    $f = path_for($name);
    if (!file_exists($f)) return [];
    $raw = file_get_contents($f);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}
function save_json($name, array $data) {
    $f = path_for($name);
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    $fp = fopen($f, 'c+'); if (!$fp) die("Kunne ikke åpne $f for skriving.");
    if (!flock($fp, LOCK_EX)) die("Kunne ikke låse $f.");
    ftruncate($fp, 0); fwrite($fp, $json); fflush($fp); flock($fp, LOCK_UN); fclose($fp);
}
function next_id(array $rows) {
    $max = 0; foreach ($rows as $r) { $max = max($max, (int)($r['id'] ?? 0)); }
    return $max + 1;
}
function normalize($s) { return trim((string)$s); }

// ---------- Klasse ----------
function klasse_all() { return load_json('klasse'); }
function klasse_by_id($id) {
    foreach (klasse_all() as $k) if ((int)$k['id'] === (int)$id) return $k;
    return null;
}
function klasse_exists_kode($kode) {
    $kode = mb_strtolower(normalize($kode));
    foreach (klasse_all() as $k) if (mb_strtolower($k['kode']) === $kode) return true;
    return false;
}
function klasse_create($kode, $navn) {
    $kode = normalize($kode); $navn = normalize($navn);
    if ($kode === '' || $navn === '') return [false, "Klassekode og navn må fylles ut."];
    if (klasse_exists_kode($kode)) return [false, "Klassekode finnes fra før."];
    $rows = klasse_all();
    $rows[] = ['id' => next_id($rows), 'kode' => $kode, 'navn' => $navn];
    save_json('klasse', $rows);
    return [true, "Klassen er registrert."];
}
function klasse_has_students($klasse_id) {
    foreach (student_all() as $s) if ((int)($s['klasse_id'] ?? 0) === (int)$klasse_id) return true;
    return false;
}
function klasse_delete($id) {
    // NB: IKKE slett hvis det finnes studenter (i henhold til krav)
    if (klasse_has_students($id)) return [false, "Kan ikke slette: klassen har studenter."];
    $rows = klasse_all();
    $rows = array_values(array_filter($rows, fn($r) => (int)$r['id'] !== (int)$id));
    save_json('klasse', $rows);
    return [true, "Klassen er slettet."];
}

// ---------- Student ----------
function student_all() { return load_json('student'); }
function student_exists_brukernavn($brukernavn) {
    $u = mb_strtolower(normalize($brukernavn));
    foreach (student_all() as $s) if (mb_strtolower($s['brukernavn']) === $u) return true;
    return false;
}
function student_create($brukernavn, $navn, $klasse_id = null) {
    $brukernavn = normalize($brukernavn); $navn = normalize($navn);
    if ($brukernavn === '' || $navn === '') return [false, "Brukernavn og navn må fylles ut."];
    if (student_exists_brukernavn($brukernavn)) return [false, "Brukernavn finnes fra før."];
    // valider klasse_id hvis oppgitt
    if ($klasse_id !== '' && $klasse_id !== null) {
        $k = klasse_by_id((int)$klasse_id);
        if (!$k) return [false, "Ugyldig klasse valgt."];
        $klasse_id = (int)$klasse_id;
    } else {
        $klasse_id = null;
    }
    $rows = student_all();
    $rows[] = ['id' => next_id($rows), 'brukernavn' => $brukernavn, 'navn' => $navn, 'klasse_id' => $klasse_id];
    save_json('student', $rows);
    return [true, "Studenten er registrert."];
}
function student_delete($id) {
    $rows = student_all();
    $rows = array_values(array_filter($rows, fn($r) => (int)$r['id'] !== (int)$id));
    save_json('student', $rows);
    return [true, "Student er slettet."];
}
