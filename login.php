<?php
session_start();
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = trim($_POST['ids'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($ids === '') $errors[] = "Podaj ID użytkownika.";
    if ($password === '') $errors[] = "Podaj hasło.";

    if (empty($errors)) {
        $sql = "SELECT * FROM brz_uzytkownicy WHERE ids = :ids LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ids' => $ids]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['ids'] = $user['ids'];
            setcookie('user_id', $user['ids'], time() + 3600, '/'); 
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Nieprawidłowe dane logowania.";
        }
    }
}

?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Logowanie — Rejestr</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{background:#f4f6f8;font-family:Inter, Arial, sans-serif}
  .box{max-width:520px;margin:6vh auto;padding:24px;background:#fff;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,0.06);}
</style>
</head>
<body>
<main class="box" role="main" aria-labelledby="login-heading">
  <h1 id="login-heading" class="h4 mb-3">Zaloguj się</h1>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger" role="alert" aria-live="assertive">
      <ul class="mb-0">
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <div class="mb-3">
      <label for="ids" class="form-label">ID użytkownika</label>
      <input id="ids" name="ids" class="form-control" value="<?= isset($ids) ? htmlspecialchars($ids) : '' ?>" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Hasło</label>
      <input id="password" name="password" type="password" class="form-control" required>
    </div>

    <div class="d-grid">
      <button class="btn btn-primary" type="submit">Zaloguj</button>
    </div>
  </form>

  <div class="mt-3">
    <a href="index.php">Powrót</a> · <a href="register.php">Utwórz konto</a>
  </div>
</main>
</body>
</html>
