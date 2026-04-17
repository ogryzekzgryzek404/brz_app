<?php
session_start();
require 'db.php';

if (isset($_SESSION['ids'])) {
    header("Location: dashboard.php");
    exit;
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ids = trim($_POST['ids'] ?? '');
    $imie_i_nazwisko = trim($_POST['imie_i_nazwisko'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $ids_urzedu = isset($_POST['ids_urzedu']) ? (int)$_POST['ids_urzedu'] : 0;

    if ($ids === '') $errors[] = "Pole 'ID użytkownika' jest wymagane.";
    if ($password === '' || strlen($password) < 6) $errors[] = "Hasło musi mieć co najmniej 6 znaków.";
    if ($password !== $password_confirm) $errors[] = "Hasło i potwierdzenie hasła nie są zgodne.";
    if ($ids_urzedu <= 0) $errors[] = "Musisz wybrać urząd.";

    if (empty($errors)) {
        $check = $pdo->prepare("SELECT ids FROM brz_uzytkownicy WHERE ids = :ids");
        $check->execute([':ids' => $ids]);
        if ($check->fetch()) {
            $errors[] = "Użytkownik o takim ID już istnieje.";
        }
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO brz_uzytkownicy (ids, imie_i_nazwisko, password_hash, ids_urzedu)
                VALUES (:ids, :imie, :pass, :urz)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':ids' => $ids,
                ':imie' => $imie_i_nazwisko,
                ':pass' => $password_hash,
                ':urz' => $ids_urzedu
            ]);
            $success = "Konto utworzone pomyślnie. Możesz się teraz zalogować.";
        } catch (PDOException $e) {
            $errors[] = "Błąd bazy danych.";
        }
    }
}

$urzedy = $pdo->query("SELECT ids, nazwa_urzedu FROM brz_urzedy ORDER BY nazwa_urzedu ASC")->fetchAll(PDO::FETCH_ASSOC);

?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Rejestr — Rejestracja</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#f4f6f8; font-family:Inter, Arial, sans-serif; }
  .box { max-width:700px; margin:6vh auto; background:#fff; padding:24px; border-radius:8px; box-shadow:0 8px 28px rgba(0,0,0,0.06); }
</style>
</head>
<body>
<main class="box" role="main" aria-labelledby="reg-heading">
  <h1 id="reg-heading" class="h4 mb-3">Utwórz konto</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger" aria-live="assertive">
      <ul class="mb-0">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success" aria-live="polite"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="row g-3">

      <div class="col-md-4">
        <label class="form-label" for="ids">ID użytkownika</label>
        <input id="ids" name="ids" class="form-control" required value="<?= htmlspecialchars($_POST['ids'] ?? '') ?>">
      </div>

      <div class="col-md-8">
        <label class="form-label" for="imie_i_nazwisko">Imię i nazwisko</label>
        <input id="imie_i_nazwisko" name="imie_i_nazwisko" class="form-control" value="<?= htmlspecialchars($_POST['imie_i_nazwisko'] ?? '') ?>">
      </div>

      <div class="col-md-6">
        <label class="form-label" for="password">Hasło</label>
        <input id="password" name="password" type="password" class="form-control" minlength="6" required>
        <div class="form-text">Minimum 6 znaków.</div>
      </div>

      <div class="col-md-6">
        <label class="form-label" for="password_confirm">Potwierdź hasło</label>
        <input id="password_confirm" name="password_confirm" type="password" class="form-control" minlength="6" required>
      </div>

      <div class="col-md-6">
        <label class="form-label" for="ids_urzedu">Wybierz urząd</label>
        <select id="ids_urzedu" name="ids_urzedu" class="form-select" required>
          <option value="">-- wybierz urząd --</option>
          <?php foreach ($urzedy as $u): ?>
            <option value="<?= (int)$u['ids'] ?>"
                    <?= (!empty($_POST['ids_urzedu']) && $_POST['ids_urzedu'] == $u['ids']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($u['nazwa_urzedu']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-12 d-flex gap-2">
        <button class="btn btn-primary">Utwórz konto</button>
        <a href="index.php" class="btn btn-outline-secondary">Powrót</a>
      </div>
    </div>
  </form>
</main>
</body>
</html>
