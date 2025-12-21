<?php
declare(strict_types=1);

function h(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function validateEmail(string $email): bool {
  return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function ensureSurveyDir(string $dir): void {
  if (!is_dir($dir)) {
    mkdir($dir, 0775, true);
  }
}

function makeFilename(): string {
  // дата+час в імені файлу (вимога методички)
  return date('Ymd_His') . '_' . bin2hex(random_bytes(3));
}

function saveSurveyResponse(string $dir, array $data): string {
  ensureSurveyDir($dir);
  $filename = makeFilename() . '.json';
  $path = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $filename;

  $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
  file_put_contents($path, $json);

  return $filename;
}
