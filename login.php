<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = trim($_POST['login'] ?? '');
  $pass  = trim($_POST['password'] ?? '');

  if (login_admin($login, $pass)) {
    header('Location: /admin.php');
    exit;
  }
  $error = 'Невірний логін або пароль';
}
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin login</title>
  <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
<div class="container">
  <h1>Вхід адміністратора</h1>

  <?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <div class="card">
    <form method="POST">
      <label>Логін</label>
      <input name="login" required>

      <label>Пароль</label>
      <input type="password" name="password" required>

      <p><button type="submit">Увійти</button></p>
    </form>
  </div>
</div>
</body>
</html>
