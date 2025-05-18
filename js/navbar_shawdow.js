window.addEventListener("scroll", function () {
  var navbar = document.getElementById("navbar");

  // Check if the page is scrolled by more than 50px
  if (window.scrollY > 50) {
    navbar.classList.add("navbar-shadow");
  } else {
    navbar.classList.remove("navbar-shadow");
  }
});
