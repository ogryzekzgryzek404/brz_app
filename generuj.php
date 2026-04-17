<?php
session_start();
require 'db.php';

if (!isset($_SESSION['ids'])) exit("Brak uprawnień.");

$uid = $_SESSION['ids'];

$stmtU = $pdo->prepare("
    SELECT uz.ids, uz.nazwa_urzedu, uz.teryt
    FROM brz_uzytkownicy u
    JOIN brz_urzedy uz ON uz.ids = u.ids_urzedu
    WHERE u.ids = :id
");
$stmtU->execute([':id' => $uid]);
$user = $stmtU->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("
    SELECT 
        r.ids AS id,
        r.data_znalezienia,
        r.miejsce_znalezienia AS miejsce,
        k.kategoria,
        r.opis_rzeczy AS opis,
        r.znak_sprawy,
        r.termin_odbioru,
        r.OZ AS oz,
        r.hash_numeru,
        YEAR(r.data_znalezienia) AS rok
    FROM brz_rejestr r
    LEFT JOIN brz_kategorie k ON k.ids = r.rodzaj_rzeczy
    WHERE r.id_urzedu = :u
");

$stmt->execute([':u' => $user['ids']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grouped = [];
foreach ($rows as $r) {
    $y = $r['rok'];
    unset($r['rok']);
    $grouped[$y][] = $r;
}

$output = [
    "meta" => [
        "teryt" => $user['teryt'],
        "urzad" => $user['nazwa_urzedu'],
        "lata"  => array_keys($grouped),
        "records_count" => count($rows),
        "generated_at" => date("c")
    ],
    "dane" => $grouped
];

$filename = "rejestr_full_teryt_{$user['teryt']}.json";

header('Content-Type: application/json');
header("Content-Disposition: attachment; filename=\"$filename\"");
echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
