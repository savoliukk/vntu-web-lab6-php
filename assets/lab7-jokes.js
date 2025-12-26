(function () {
  function pickRandom(arr) {
    return arr[Math.floor(Math.random() * arr.length)];
  }

  function loadRandomJoke() {
    $("#jokeBox").text("Завантажую...");

    $.get("/data/jokes.txt")
      .done(function (text) {
        const jokes = text
          .split("\n")
          .map(s => s.trim())
          .filter(Boolean);

        if (jokes.length === 0) {
          $("#jokeBox").text("Файл жартів порожній.");
          return;
        }

        $("#jokeBox").text(pickRandom(jokes));
      })
      .fail(function () {
        $("#jokeBox").text("Не вдалося завантажити /data/jokes.txt (перевір шлях).");
      });
  }

  $("#btnJoke").on("click", loadRandomJoke);
})();
