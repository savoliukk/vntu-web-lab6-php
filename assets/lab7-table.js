(function () {
  const API_URL = "/api/lab7_proxy.php";

  function escapeHtml(s) {
    return String(s)
      .replaceAll("&", "&amp;")
      .replaceAll("<", "&lt;")
      .replaceAll(">", "&gt;")
      .replaceAll('"', "&quot;")
      .replaceAll("'", "&#039;");
  }

  function render(rows) {
    const html = rows.map(r =>
      `<tr><td>${escapeHtml(r.name ?? "")}</td><td>${escapeHtml(r.affiliation ?? "")}</td></tr>`
    ).join("");
    $("#tblBody").html(html);
  }

  function loadData() {
    const sortBy = $("#sortBy").val();
    $("#status").text("Завантажую...");

    $.getJSON(API_URL)
      .done(function (data) {
        const rows = Array.isArray(data) ? data : (data.items || data.data || []);
        rows.sort((a, b) => String(a[sortBy] ?? "").localeCompare(String(b[sortBy] ?? ""), "uk"));
        render(rows);
        $("#status").text("OK");
      })
      .fail(function () {
        $("#status").text("Помилка завантаження.");
        $("#tblBody").html("");
      });
  }

  $("#btnRefresh").on("click", loadData);
  $("#sortBy").on("change", loadData);

  loadData();
})();
