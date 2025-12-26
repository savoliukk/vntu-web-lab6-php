<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/auth.php';
require_once __DIR__ . '/inc/db.php';

require_admin();

$pdo = db();
$rows = $pdo->query("SELECT * FROM survey_responses ORDER BY id DESC LIMIT 200")->fetchAll();

$csrf = csrf_token();
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
<div class="container">
  <div class="card">
    <h1>Admin: відповіді анкети</h1>
    <p><small>Вхід: <?= htmlspecialchars($_SESSION['admin']['login'] ?? '') ?>, час: <?= htmlspecialchars($_SESSION['admin']['login_at'] ?? '') ?></small></p>
    <p>
      <a href="/export.php">Export CSV</a> |
      <a href="/logout.php">Logout</a>
    </p>
  </div>

  <?php foreach ($rows as $r): ?>
    <div class="card">
      <p><strong>ID:</strong> <?= (int)$r['id'] ?> | <strong>submitted_at:</strong> <?= htmlspecialchars($r['submitted_at']) ?></p>
      <p><strong>Ім’я:</strong> <?= htmlspecialchars($r['name']) ?> | <strong>Email:</strong> <?= htmlspecialchars($r['email']) ?></p>
      <p><strong>Q1:</strong> <?= htmlspecialchars($r['q1_lang']) ?> | <strong>Q2:</strong> <?= htmlspecialchars($r['q2_hours']) ?> | <strong>Q3:</strong> <?= htmlspecialchars($r['q3_ai']) ?></p>

      <details>
        <summary>Текстові відповіді</summary>
        <p><strong>Q4:</strong> <?= nl2br(htmlspecialchars($r['q4_hard'])) ?></p>
        <p><strong>Q5:</strong> <?= nl2br(htmlspecialchars($r['q5_wish'] ?? '')) ?></p>
      </details>

      <?php if (!empty($r['file_name'])): ?>
        <p><small>Файл: <code><?= htmlspecialchars($r['file_name']) ?></code></small></p>
      <?php endif; ?>

      <form method="POST" action="/delete.php" onsubmit="return confirm('Видалити цей запис?');">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button type="submit">Delete</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
