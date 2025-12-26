<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/auth.php';
require_once __DIR__ . '/inc/db.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /admin.php');
  exit;
}

$token = $_POST['csrf'] ?? '';
if (!csrf_check($token)) {
  http_response_code(403);
  echo "CSRF error";
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
  header('Location: /admin.php');
  exit;
}

$pdo = db();

// дістанемо file_name, щоб (за бажанням) стерти файл
$stmt = $pdo->prepare("SELECT file_name FROM survey_responses WHERE id = ?");
$stmt->execute([$id]);
$row = $stmt->fetch();

$stmt = $pdo->prepare("DELETE FROM survey_responses WHERE id = ?");
$stmt->execute([$id]);

// Якщо хочеш також прибирати файл з survey/
if (!empty($row['file_name'])) {
  $path = __DIR__ . '/survey/' . basename($row['file_name']);
  if (is_file($path)) {
    @unlink($path);
  }
}

header('Location: /admin.php');
exit;
