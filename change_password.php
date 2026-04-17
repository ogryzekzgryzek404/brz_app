<?php
session_start();
require 'db.php';

if (!isset($_SESSION['ids'])) {
    header("Location: login.php");
    exit();
}

$ids = $_SESSION['ids'];
$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($current === '') $errors[] = "Podaj bieżące hasło.";
    if ($new === '' || strlen($new) < 6) $errors[] = "Nowe hasło musi mieć co najmniej 6 znaków.";
    if ($new !== $confirm) $errors[] = "Nowe hasło i potwierdzenie hasła nie są zgodne.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM brz_uzytkownicy WHERE ids = :ids LIMIT 1");
        $stmt->execute([':ids' => $ids]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current, $user['password_hash'])) {
            $errors[] = "Bieżące hasło jest nieprawidłowe.";
        } else {
            $new_hash = password_hash($new, PASSWORD_DEFAULT);
            $upd = $pdo->prepare("UPDATE brz_uzytkownicy SET password_hash = :h WHERE ids = :ids");
            $upd->execute([':h' => $new_hash, ':ids' => $ids]);
            $success = "Hasło zostało pomyślnie zmienione.";
        }
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Zmiana hasła — Rejestr</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{background:#f4f6f8;font-family:Inter, Arial, sans-serif}
  .box{max-width:520px;margin:6vh auto;padding:24px;background:#fff;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,0.06);}
</style>
</head>
<body>

<main class="box" role="main" aria-labelledby="pw-title">
  <h1 id="pw-title" class="h5 mb-3">Zmień hasło</h1>

  <?php if ($errors): ?>
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
    <div class="mb-3">
      <label for="current_password" class="form-label">Bieżące hasło</label>
      <input id="current_password" name="current_password" type="password" class="form-control" required autocomplete="current-password">
    </div>

    <div class="mb-3">
      <label for="new_password" class="form-label">Nowe hasło</label>
      <input id="new_password" name="new_password" type="password" class="form-control" minlength="6" required autocomplete="new-password">
      <div class="form-text">Minimum 6 znaków.</div>
    </div>

    <div class="mb-3">
      <label for="confirm_password" class="form-label">Potwierdź nowe hasło</label>
      <input id="confirm_password" name="confirm_password" type="password" class="form-control" minlength="6" required autocomplete="new-password">
    </div>

    <div class="d-flex gap-2">
      <button class="btn btn-primary" type="submit">Zmień hasło</button>
      <a href="dashboard.php" class="btn btn-outline-secondary">Powrót</a>
    </div>
  </form>
</main>

</body>
</html>
