document
  .getElementById("search")
  .addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      var search = this.value;
      var category = document.getElementById("category").value;
      var sort = document.getElementById("sort").value;
      window.location.href = `?search=${search}&category=${category}&sort=${sort}`;
    }
  });

document.getElementById("category").addEventListener("change", function () {
  var search = document.getElementById("search").value;
  var category = this.value;
  var sort = document.getElementById("sort").value;
  window.location.href = `?search=${search}&category=${category}&sort=${sort}`;
});

document.getElementById("sort").addEventListener("change", function () {
  var search = document.getElementById("search").value;
  var category = document.getElementById("category").value;
  var sort = this.value;
  window.location.href = `?search=${search}&category=${category}&sort=${sort}`;
});
