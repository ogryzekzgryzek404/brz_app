<?php
session_start();
require 'db.php';

if (!isset($_SESSION['ids']) && isset($_COOKIE['user_id'])) {
    $_SESSION['ids'] = $_COOKIE['user_id'];
}

if (isset($_SESSION['ids'])) {
    header("Location: dashboard.php");
    exit;
}

$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html lang="pl">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Centralny Rejestr Rzeczy Znalezionych – Logowanie</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#f4f6f8; font-family:Inter, Arial, sans-serif; }
  .login-box { max-width:420px; margin:6vh auto; padding:24px; background:#fff; border-radius:8px; box-shadow:0 6px 20px rgba(0,0,0,0.06); }
  .app-title { font-size:1.25rem; font-weight:700; text-align:center; margin-bottom:16px; }
  .visually-hidden { position:absolute !important; height:1px; width:1px; overflow:hidden; clip:rect(1px,1px,1px,1px); white-space:nowrap; border:0; padding:0; margin:-1px; }
  @media (prefers-reduced-motion: reduce){ * { transition: none !important; } }
</style>
</head>
<body>
<main class="login-box" role="main" aria-labelledby="login-title">
  <h1 id="login-title" class="app-title">Centralny Rejestr Rzeczy Znalezionych</h1>

  <?php if ($msg): ?>
    <div class="alert alert-info" role="status" aria-live="polite"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form method="POST" action="login.php" novalidate aria-describedby="login-note">
    <div class="mb-3">
      <label for="ids" class="form-label">ID użytkownika</label>
      <input type="text" id="ids" name="ids" class="form-control" required aria-required="true" autocomplete="username">
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Hasło</label>
      <input type="password" id="password" name="password" class="form-control" required aria-required="true" autocomplete="current-password" minlength="6">
      <div id="password-hint" class="form-text">Minimum 6 znaków.</div>
    </div>

    <div class="d-grid gap-2">
      <button class="btn btn-primary" type="submit">Zaloguj</button>
    </div>
  </form>

  <div class="text-center mt-3">
    <a href="register.php">Utwórz konto</a>
  </div>

  <p id="login-note" class="visually-hidden">Formularz logowania. Po udanym logowaniu nastąpi przekierowanie do panelu.</p>
</main>

</body>
</html>
