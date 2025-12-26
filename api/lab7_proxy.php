<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

// Тягнемо з HTTP на сервері (браузер не блокує, бо це server-to-server)
$url = 'http://lab.vntu.org/api-server/lab7.php';

$ch = curl_init($url);
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CONNECTTIMEOUT => 8,
  CURLOPT_TIMEOUT => 12,
]);

$body = curl_exec($ch);
$code = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
$err  = curl_error($ch);
curl_close($ch);

if ($body === false || $code < 200 || $code >= 300) {
  http_response_code(502);
  echo json_encode(['ok' => false, 'error' => 'Proxy fetch failed', 'details' => $err], JSON_UNESCAPED_UNICODE);
  exit;
}

echo $body;
