<?php
session_start();
require 'db.php';

if (!isset($_SESSION['ids'])) exit("Brak uprawnień.");

$rok = (int)($_GET['rok'] ?? 0);
if ($rok <= 0) exit("Błędny rok.");

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
        r.hash_numeru
    FROM brz_rejestr r
    LEFT JOIN brz_kategorie k ON k.ids = r.rodzaj_rzeczy
    WHERE r.id_urzedu = :u AND YEAR(r.data_znalezienia) = :y
");

$stmt->execute([
    ':u' => $user['ids'],
    ':y' => $rok
]);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = [
    "meta" => [
        "teryt" => $user['teryt'],
        "urzad" => $user['nazwa_urzedu'],
        "rok" => $rok,
        "records_count" => count($rows),
        "generated_at" => date("c")
    ],
    "dane" => $rows
];

$filename = "rejestr_rok_{$rok}_teryt_{$user['teryt']}.json";

header('Content-Type: application/json');
header("Content-Disposition: attachment; filename=\"$filename\"");
echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
