<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/functions.php';

$errors = [];
$old = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');

  $q1 = trim($_POST['q1_lang'] ?? '');
  $q2 = trim($_POST['q2_hours'] ?? '');
  $q3 = trim($_POST['q3_ai'] ?? '');
  $q4 = trim($_POST['q4_hard'] ?? '');
  $q5 = trim($_POST['q5_wish'] ?? '');

  $old = compact('name','email') + [
    'q1_lang'=>$q1,'q2_hours'=>$q2,'q3_ai'=>$q3,'q4_hard'=>$q4,'q5_wish'=>$q5
  ];

  if ($name === '') $errors[] = "Ім’я обов’язкове.";
  if ($email === '' || !validateEmail($email)) $errors[] = "Некоректний email.";
  if ($q4 === '') $errors[] = "Питання 4 обов’язкове.";

  if (empty($errors)) {
    $submittedAt = date('d.m.Y H:i:s');

    $data = [
      'submitted_at' => $submittedAt,
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

    $savedFile = saveSurveyResponse(__DIR__ . '/survey', $data);

    require __DIR__ . '/templates/header.php';
    require __DIR__ . '/templates/success.php';
    require __DIR__ . '/templates/footer.php';
    exit;
  }
}

require __DIR__ . '/templates/header.php';
require __DIR__ . '/templates/form.php';
require __DIR__ . '/templates/footer.php';
