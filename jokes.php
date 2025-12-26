<?php
declare(strict_types=1);
require __DIR__ . '/templates/header.php';
?>
<main class="container" style="max-width: 900px; margin: 0 auto; padding: 16px;">
  <h1>Випадковий жарт про програмування</h1>

  <div id="jokeBox" style="border:1px solid #ccc; border-radius:10px; padding:16px; margin:12px 0;">
    Натисни кнопку, щоб завантажити жарт 🙂
  </div>

  <button id="btnJoke" type="button">Показати випадковий жарт</button>
</main>

<script src="/assets/lab7-jokes.js"></script>
<?php require __DIR__ . '/templates/footer.php'; ?>
