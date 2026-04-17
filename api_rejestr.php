<?php
session_start();
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['ids'])) {
    echo json_encode(['success'=>false, 'error'=>'Not authenticated']);
    exit;
}

$userId = $_SESSION['ids'];

$stmt = $pdo->prepare("SELECT ids_urzedu FROM brz_uzytkownicy WHERE ids = :id");
$stmt->execute([':id'=>$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(['success'=>false,'error'=>'User not found']);
    exit;
}

$idUrzeduUser = (int)$user['ids_urzedu'];

function j($arr){
    echo json_encode($arr);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'list') {

    $id_urzedu = isset($_GET['id_urzedu']) ? (int)$_GET['id_urzedu'] : $idUrzeduUser;
    $year      = isset($_GET['year']) ? (int)$_GET['year'] : 0;

    if ($id_urzedu !== $idUrzeduUser) {
        j(['success'=>false, 'error'=>'Brak uprawnień do tej jednostki']);
    }

    $sql = "
        SELECT r.*, k.kategoria
        FROM brz_rejestr r
        LEFT JOIN brz_kategorie k ON k.ids = r.rodzaj_rzeczy
        WHERE r.id_urzedu = :u
        AND (:year = 0 OR YEAR(r.data_znalezienia) = :year)
        ORDER BY r.ids DESC
    ";

    $s = $pdo->prepare($sql);
    $s->execute([
        ':u'    => $id_urzedu,
        ':year' => $year
    ]);

    j($s->fetchAll(PDO::FETCH_ASSOC));
}

if (isset($_GET['action']) && $_GET['action'] === 'get' && isset($_GET['ids'])) {

    $ids = (int)$_GET['ids'];

    $s = $pdo->prepare("SELECT * FROM brz_rejestr WHERE ids = :ids AND id_urzedu = :u");
    $s->execute([':ids'=>$ids, ':u'=>$idUrzeduUser]);

    $row = $s->fetch(PDO::FETCH_ASSOC);

    if (!$row) j(['success'=>false,'error'=>'Record not found or permission denied']);

    j($row);
}

if (isset($_GET['action']) && $_GET['action'] === 'years') {

    $stmt = $pdo->prepare("
        SELECT DISTINCT YEAR(data_znalezienia) AS y
        FROM brz_rejestr
        WHERE id_urzedu = :u
        ORDER BY y DESC
    ");
    $stmt->execute([':u' => $idUrzeduUser]);

    j($stmt->fetchAll(PDO::FETCH_COLUMN));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'add') {

        $data_znalezienia = $_POST['data_znalezienia'] ?? null;
        $miejsce          = $_POST['miejsce_znalezienia'] ?? '';
        $rodzaj           = $_POST['rodzaj_rzeczy'] ?? null;
        $opis             = $_POST['opis_rzeczy'] ?? '';
        $numer            = trim($_POST['numer_seryjny'] ?? '');
        $hash_numeru      = $numer !== '' ? hash_hmac('sha256', $numer, HASH_SECRET) : null;
        $znak             = $_POST['znak_sprawy'] ?? null;
        $oz               = isset($_POST['OZ']) ? 1 : 0;

        $termin_odbioru = $_POST['termin_odbioru'] ?? null;
        if ($termin_odbioru) {
            $termin_odbioru = substr($termin_odbioru, 0, 10);
        }

        $id_urzedu = isset($_POST['id_urzedu']) ? (int)$_POST['id_urzedu'] : $idUrzeduUser;

        if ($id_urzedu !== $idUrzeduUser)
            j(['success'=>false,'error'=>'Brak uprawnień do tej jednostki']);

        if ($data_znalezienia) {
            $data_znalezienia = substr($data_znalezienia, 0, 10);
        } else {
            $data_znalezienia = date('Y-m-d');
        }

        $sql = "
            INSERT INTO brz_rejestr
            (data_znalezienia, termin_odbioru, miejsce_znalezienia,
             rodzaj_rzeczy, opis_rzeczy, numer_seryjny, hash_numeru,
             id_urzedu, znak_sprawy, OZ)
            VALUES
            (:data, :termin, :miejsce, :rodzaj, :opis, :numer, :hash,
             :urz, :znak, :oz)
        ";

        $s = $pdo->prepare($sql);
        $s->execute([
            ':data'   => $data_znalezienia,
            ':termin' => $termin_odbioru,
            ':miejsce'=> $miejsce,
            ':rodzaj' => $rodzaj,
            ':opis'   => $opis,
            ':numer'  => $numer,
            ':hash'   => $hash_numeru,
            ':urz'    => $id_urzedu,
            ':znak'   => $znak,
            ':oz'     => $oz
        ]);

        j(['success'=>true, 'ids'=>$pdo->lastInsertId()]);
    }

    if ($action === 'edit') {

        $ids = isset($_POST['ids']) ? (int)$_POST['ids'] : 0;
        if (!$ids) j(['success'=>false,'error'=>'No ID']);

        $check = $pdo->prepare("SELECT id_urzedu FROM brz_rejestr WHERE ids = :ids");
        $check->execute([':ids'=>$ids]);

        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['id_urzedu'] !== $idUrzeduUser)
            j(['success'=>false,'error'=>'Record not found or permission denied']);

        $data_znalezienia = $_POST['data_znalezienia'] ?? null;
        $miejsce          = $_POST['miejsce_znalezienia'] ?? '';
        $rodzaj           = $_POST['rodzaj_rzeczy'] ?? null;
        $opis             = $_POST['opis_rzeczy'] ?? '';
        $numer            = trim($_POST['numer_seryjny'] ?? '');
        $hash_numeru      = $numer !== '' ? hash_hmac('sha256', $numer, HASH_SECRET) : null;
        $znak             = $_POST['znak_sprawy'] ?? null;
        $oz               = isset($_POST['OZ']) ? 1 : 0;

        $termin_odbioru = $_POST['termin_odbioru'] ?? null;
        if ($termin_odbioru) {
            $termin_odbioru = substr($termin_odbioru, 0, 10);
        }

        if ($data_znalezienia) {
            $data_znalezienia = substr($data_znalezienia, 0, 10);
        } else {
            $data_znalezienia = date('Y-m-d');
        }

        $sql = "
            UPDATE brz_rejestr SET
            data_znalezienia = :data,
            termin_odbioru   = :termin,
            miejsce_znalezienia = :miejsce,
            rodzaj_rzeczy    = :rodzaj,
            opis_rzeczy      = :opis,
            numer_seryjny    = :numer,
            hash_numeru      = :hash,
            znak_sprawy      = :znak,
            OZ               = :oz
            WHERE ids = :ids AND id_urzedu = :urz
        ";

        $s = $pdo->prepare($sql);
        $s->execute([
            ':data'   => $data_znalezienia,
            ':termin' => $termin_odbioru,
            ':miejsce'=> $miejsce,
            ':rodzaj' => $rodzaj,
            ':opis'   => $opis,
            ':numer'  => $numer,
            ':hash'   => $hash_numeru,
            ':znak'   => $znak,
            ':oz'     => $oz,
            ':ids'    => $ids,
            ':urz'    => $idUrzeduUser
        ]);

        j(['success'=>true]);
    }

    if ($action === 'delete') {

        $ids = isset($_POST['ids']) ? (int)$_POST['ids'] : 0;
        if (!$ids) j(['success'=>false,'error'=>'No ID']);

        $check = $pdo->prepare("SELECT id_urzedu FROM brz_rejestr WHERE ids = :ids");
        $check->execute([':ids'=>$ids]);

        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row || (int)$row['id_urzedu'] !== $idUrzeduUser)
            j(['success'=>false,'error'=>'Record not found or permission denied']);

        $s = $pdo->prepare("DELETE FROM brz_rejestr WHERE ids = :ids AND id_urzedu = :u");
        $s->execute([':ids'=>$ids, ':u'=>$idUrzeduUser]);

        j(['success'=>true]);
    }

    j(['success'=>false,'error'=>'Unknown action']);
}

j(['success'=>false,'error'=>'Invalid request']);
