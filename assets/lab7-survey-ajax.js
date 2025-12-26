(function () {
  $("#surveyForm").on("submit", function (e) {
    e.preventDefault();

    const $form = $(this);
    $("#ajaxResult").html("Надсилаю...");

    $.ajax({
      url: "/api/submit.php",
      method: "POST",
      data: $form.serialize(),
      dataType: "json",
    })
      .done(function (res) {
        if (!res.ok) {
          $("#ajaxResult").html("Сталася помилка.");
          return;
        }

        $("#ajaxResult").html(
          `<b>Успішно!</b><br>` +
          `Дата/час: ${res.submitted_at}<br>` +
          `Файл: ${res.saved_file}` +
          (res.db_id ? `<br>ID у БД: ${res.db_id}` : "")
        );

        $form[0].reset();
      })
      .fail(function (xhr) {
        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
          const list = xhr.responseJSON.errors.map(e => `<li>${e}</li>`).join("");
          $("#ajaxResult").html(`<b>Помилки:</b><ul>${list}</ul>`);
          return;
        }
        $("#ajaxResult").html("Не вдалося надіслати форму (перевір /api/submit.php).");
      });
  });
})();
