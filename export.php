<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/auth.php';
require_once __DIR__ . '/inc/db.php';

require_admin();

$pdo = db();
$rows = $pdo->query("SELECT * FROM survey_responses ORDER BY id DESC")->fetchAll();

$filename = 'survey_export_' . date('Ymd_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="'.$filename.'"');

$out = fopen('php://output', 'w');

// (не обов’язково) BOM для Excel:
fwrite($out, "\xEF\xBB\xBF");

fputcsv($out, ['id','submitted_at','name','email','q1_lang','q2_hours','q3_ai','q4_hard','q5_wish','file_name','ip','user_agent']);

foreach ($rows as $r) {
  fputcsv($out, [
    $r['id'], $r['submitted_at'], $r['name'], $r['email'],
    $r['q1_lang'], $r['q2_hours'], $r['q3_ai'],
    $r['q4_hard'], $r['q5_wish'], $r['file_name'],
    $r['ip'], $r['user_agent'],
  ]);
}

fclose($out);
exit;
