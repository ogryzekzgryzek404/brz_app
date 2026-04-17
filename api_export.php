<?php
require 'db.php';
header('Content-Type: application/json; charset=utf-8');

$teryt = isset($_GET['teryt']) ? trim($_GET['teryt']) : '';
$rok   = isset($_GET['rok']) ? (int)$_GET['rok'] : 0;

if ($teryt === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing teryt parameter'], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmtU = $pdo->prepare("
    SELECT ids, nazwa_urzedu, teryt
    FROM brz_urzedy
    WHERE teryt = :t
");
$stmtU->execute([':t' => $teryt]);
$urzad = $stmtU->fetch(PDO::FETCH_ASSOC);

if (!$urzad) {
    http_response_code(404);
    echo json_encode(['error' => 'Urząd not found for given teryt'], JSON_UNESCAPED_UNICODE);
    exit;
}

$idUrzedu = (int)$urzad['ids'];

if ($rok === 0) {

    $stmt = $pdo->prepare("
        SELECT DISTINCT YEAR(data_znalezienia)
        FROM brz_rejestr
        WHERE id_urzedu = :u
        ORDER BY 1 DESC
    ");
    $stmt->execute([':u' => $idUrzedu]);
    $years = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode([
        "meta" => [
            "teryt" => $urzad['teryt'],
            "urzad" => $urzad['nazwa_urzedu'],
            "available_years" => array_map('intval', $years),
            "generated_at" => date("c")
        ],
        "endpoints" => array_map(
            fn($y) => "/api_export.php?teryt={$urzad['teryt']}&rok={$y}",
            $years
        )
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

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

        -- ✅ SECURITY: HASH ONLY, NEVER PLAIN SERIAL
        r.hash_numeru

    FROM brz_rejestr r
    LEFT JOIN brz_kategorie k ON k.ids = r.rodzaj_rzeczy
    WHERE r.id_urzedu = :u
      AND YEAR(r.data_znalezienia) = :y
    ORDER BY r.data_znalezienia DESC
");

$stmt->execute([
    ':u' => $idUrzedu,
    ':y' => $rok
]);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "meta" => [
        "teryt" => $urzad['teryt'],
        "urzad" => $urzad['nazwa_urzedu'],
        "rok"   => $rok,
        "records_count" => count($rows),
        "generated_at" => date("c")
    ],
    "dane" => $rows
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

exit;
