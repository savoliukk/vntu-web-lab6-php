<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/functions.php';

$dir = __DIR__ . '/survey';
$files = glob($dir . '/*.json') ?: [];
rsort($files);

require __DIR__ . '/templates/header.php';
?>
<div class="card">
  <h2>Admin: відповіді анкети</h2>
  <p><small>Знайдено файлів: <strong><?= count($files) ?></strong></small></p>
</div>

<?php foreach ($files as $path): ?>
  <?php
    $raw = file_get_contents($path);
    $data = json_decode($raw, true) ?: [];
    $base = basename($path);
  ?>
  <div class="card">
    <p><strong>Файл:</strong> <code><?= h($base) ?></code></p>
    <p><strong>Дата/час:</strong> <?= h($data['submitted_at'] ?? '-') ?></p>
    <p><strong>Ім’я:</strong> <?= h($data['name'] ?? '-') ?></p>
    <p><strong>Email:</strong> <?= h($data['email'] ?? '-') ?></p>
    <details>
      <summary>Відповіді</summary>
      <pre><?= h(json_encode($data['answers'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) ?></pre>
    </details>
  </div>
<?php endforeach; ?>

<?php
require __DIR__ . '/templates/footer.php';
