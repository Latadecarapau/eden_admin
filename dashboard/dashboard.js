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
// Get the modal
var modal = document.getElementById("deleteModal");

// Get the button that opens the modal
var btn = document.getElementById("deleteButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function () {
  modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};
