<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

function start_session(): void {
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
}

function is_admin(): bool {
  start_session();
  return !empty($_SESSION['admin']['logged_in']);
}

function require_admin(): void {
  if (!is_admin()) {
    header('Location: /login.php');
    exit;
  }
}

function login_admin(string $login, string $password): bool {
  start_session();

  if ($login !== ADMIN_LOGIN) return false;

  // password_verify працює з хешем від password_hash().
  if (!password_verify($password, ADMIN_PASS_HASH)) return false;

  $_SESSION['admin'] = [
    'logged_in' => true,
    'login' => $login,
    'login_at' => date('d.m.Y H:i:s'),
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
  ];

  // CSRF-токен для delete/export форм
  $_SESSION['csrf'] = bin2hex(random_bytes(16));

  return true;
}

function logout_admin(): void {
  start_session();
  $_SESSION = [];
  session_destroy();
}

function csrf_token(): string {
  start_session();
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }
  return (string)$_SESSION['csrf'];
}

function csrf_check(string $token): bool {
  start_session();
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}
