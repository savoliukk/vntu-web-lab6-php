<?php
declare(strict_types=1);
require __DIR__ . '/../templates/header.php';
?>
<main class="container" style="max-width: 1000px; margin: 0 auto; padding: 16px;">
  <h1>Lab7 — динамічна таблиця (jQuery)</h1>

  <div style="display:flex; gap:10px; align-items:center; margin:12px 0;">
    <label for="sortBy">Сортування:</label>
    <select id="sortBy">
      <option value="name">за іменем (name)</option>
      <option value="affiliation">за фракцією (affiliation)</option>
    </select>

    <button id="btnRefresh" type="button">Оновити дані</button>
    <span id="status"></span>
  </div>

  <table border="1" cellpadding="6" cellspacing="0" style="width:100%;">
    <thead>
      <tr><th>Name</th><th>Affiliation</th></tr>
    </thead>
    <tbody id="tblBody"></tbody>
  </table>
</main>

<script src="/assets/lab7-table.js"></script>
<?php require __DIR__ . '/../templates/footer.php'; ?>
