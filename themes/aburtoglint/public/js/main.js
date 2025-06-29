// Toggle mobile menu
document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.getElementById("hamburger");
  const nav = document.getElementById("main-nav");

  if (hamburger && nav) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("is-active");
      nav.classList.toggle("open");
    });
  }
});
