<?php // очікує $submittedAt, $savedFile ?>
<div class="card">
  <p class="ok">Дякуємо! Відповідь збережено.</p>
  <p>Дата і час заповнення: <strong><?= h($submittedAt) ?></strong></p>
  <p><small>Файл: <code><?= h($savedFile) ?></code></small></p>
  <p><a href="./index.php">Заповнити ще раз</a></p>
</div>
