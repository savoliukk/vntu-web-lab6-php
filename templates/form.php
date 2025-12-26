<?php // очікує $errors (array), $old (array) ?>
<div class="card">
  <h2>Тема: Звички вивчення програмування</h2>

  <?php if (!empty($errors)): ?>
    <p class="error"><?= h(implode(' | ', $errors)) ?></p>
  <?php endif; ?>

  <form method="POST" action="./index.php">
    <label>Ім’я респондента</label>
    <input name="name" required value="<?= h($old['name'] ?? '') ?>">

    <label>Email респондента</label>
    <input name="email" type="email" required value="<?= h($old['email'] ?? '') ?>">

    <label>1) Яку мову ти зараз вивчаєш?</label>
    <select name="q1_lang" required>
      <?php
      $opts = ['JavaScript','PHP','Python','Java','C#','Інше'];
      $sel = $old['q1_lang'] ?? '';
      foreach ($opts as $o) {
        $isSel = ($sel === $o) ? 'selected' : '';
        echo "<option $isSel>" . h($o) . "</option>";
      }
      ?>
    </select>

    <label>2) Скільки годин на тиждень ти практикуєшся?</label>
    <div class="row">
      <?php
      $hours = ['0-2','3-5','6-10','11+'];
      $selH = $old['q2_hours'] ?? '';
      foreach ($hours as $hOpt) {
        $checked = ($selH === $hOpt) ? 'checked' : '';
        echo '<label style="font-weight:400; margin:0 12px 0 0;">';
        echo '<input type="radio" name="q2_hours" value="'.h($hOpt).'" '.$checked.' required> '.h($hOpt);
        echo '</label>';
      }
      ?>
    </div>

    <label>3) Чи користуєшся AI-асистентом під час навчання?</label>
    <select name="q3_ai" required>
      <?php
      $opts2 = ['Так','Ні','Іноді'];
      $sel2 = $old['q3_ai'] ?? '';
      foreach ($opts2 as $o) {
        $isSel = ($sel2 === $o) ? 'selected' : '';
        echo "<option $isSel>" . h($o) . "</option>";
      }
      ?>
    </select>

    <label>4) Найскладніше у навчанні (1-2 речення)</label>
    <textarea name="q4_hard" rows="3" required><?= h($old['q4_hard'] ?? '') ?></textarea>

    <label>5) Побажання до курсу/лабораторних</label>
    <textarea name="q5_wish" rows="3"><?= h($old['q5_wish'] ?? '') ?></textarea>

    <p><button type="submit">Надіслати</button></p>
  </form>
</div>
