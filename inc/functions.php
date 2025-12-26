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


function saveSurveyToDb(PDO $pdo, array $row): int {
  $sql = "INSERT INTO survey_responses
    (submitted_at, name, email, q1_lang, q2_hours, q3_ai, q4_hard, q5_wish, file_name, ip, user_agent)
    VALUES
    (:submitted_at, :name, :email, :q1_lang, :q2_hours, :q3_ai, :q4_hard, :q5_wish, :file_name, :ip, :user_agent)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':submitted_at' => $row['submitted_at'],
    ':name' => $row['name'],
    ':email' => $row['email'],
    ':q1_lang' => $row['q1_lang'],
    ':q2_hours' => $row['q2_hours'],
    ':q3_ai' => $row['q3_ai'],
    ':q4_hard' => $row['q4_hard'],
    ':q5_wish' => $row['q5_wish'],
    ':file_name' => $row['file_name'],
    ':ip' => $row['ip'],
    ':user_agent' => $row['user_agent'],
  ]);

  return (int)$pdo->lastInsertId();
}
