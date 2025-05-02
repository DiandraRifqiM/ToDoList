// Toggle class active
const navbarNav = document.querySelector(".navbar-nav");

// Ketika diandras-menu diklik
document.querySelector("#diandras-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

// Klik di luar sidebar untuk menutup nav
const diandras = document.querySelector("#diandras-menu");

document.addEventListener("click", function (e) {
  if (!diandras.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});
