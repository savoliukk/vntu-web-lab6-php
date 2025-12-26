<?php
declare(strict_types=1);

// Очікує змінні з index.php:
// $submittedAt (string) - дата/час для користувача (формат d.m.Y H:i:s)
// $savedFile (string)   - назва JSON-файлу у survey/
// $dbId (int|string)    - ID запису в MySQL
?>
<div class="card">
  <p class="ok">Дякуємо! Відповідь успішно збережено.</p>

  <p>
    Дата і час заповнення:
    <strong><?= h($submittedAt ?? '-') ?></strong>
  </p>

  <p>
    ID запису в базі даних:
    <code><?= h(isset($dbId) ? (string)$dbId : '-') ?></code>
  </p>

  <p>
    Файл відповіді (JSON) у каталозі <code>survey/</code>:
    <code><?= h($savedFile ?? '-') ?></code>
  </p>

  <p>
    <a href="./index.php">Заповнити ще раз</a>
  </p>
</div>
