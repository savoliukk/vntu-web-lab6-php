<?php
declare(strict_types=1);

require_once __DIR__ . '/../inc/db.php';
require_once __DIR__ . '/../inc/functions.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
  exit;
}

$errors = [];

$name  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

$q1 = trim($_POST['q1_lang'] ?? '');
$q2 = trim($_POST['q2_hours'] ?? '');
$q3 = trim($_POST['q3_ai'] ?? '');
$q4 = trim($_POST['q4_hard'] ?? '');
$q5 = trim($_POST['q5_wish'] ?? '');

if ($name === '') $errors[] = "Ім’я обов’язкове.";
if ($email === '' || !validateEmail($email)) $errors[] = "Некоректний email.";
if ($q4 === '') $errors[] = "Питання 4 обов’язкове.";

if (!empty($errors)) {
  http_response_code(422);
  echo json_encode(['ok' => false, 'errors' => $errors], JSON_UNESCAPED_UNICODE);
  exit;
}

// Для показу користувачу
$submittedAtHuman = date('d.m.Y H:i:s');
// Для БД (DATETIME)
$submittedAtDb = date('Y-m-d H:i:s');

$data = [
  'submitted_at' => $submittedAtHuman,
  'name' => $name,
  'email' => $email,
  'answers' => [
    'q1_lang' => $q1,
    'q2_hours' => $q2,
    'q3_ai' => $q3,
    'q4_hard' => $q4,
    'q5_wish' => $q5,
  ],
  'meta' => [
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
  ],
];

// 1) JSON у survey/
$savedFile = saveSurveyResponse(__DIR__ . '/../survey', $data);

// 2) INSERT у MySQL
$pdo = db();
$dbId = saveSurveyToDb($pdo, [
  'submitted_at' => $submittedAtDb,
  'name' => $name,
  'email' => $email,
  'q1_lang' => $q1,
  'q2_hours' => $q2,
  'q3_ai' => $q3,
  'q4_hard' => $q4,
  'q5_wish' => $q5,
  'file_name' => $savedFile, // саме filename, як повертає saveSurveyResponse()
  'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
  'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
]);

echo json_encode([
  'ok' => true,
  'submitted_at' => $submittedAtHuman,
  'saved_file' => $savedFile,
  'db_id' => $dbId,
], JSON_UNESCAPED_UNICODE);
