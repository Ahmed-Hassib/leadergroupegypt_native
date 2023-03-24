
// get mega menu button
var mega_menu_btn = document.querySelectorAll(".main-nav > li");

(function () {
  mega_menu_btn.forEach(el => {
    if (el.childElementCount > 1) {
      el.addEventListener("click", (evt) => {
        el.classList.toggle('active');
      })
    }
  })
})()


/**
 * showPass function
 * used to show/hide the password
 */
function showPass(btn) {
  if (btn.classList.contains("bi-eye-slash")) {
    btn.classList.replace("bi-eye-slash", "bi-eye");
    btn.previousElementSibling.setAttribute("type", "text");
  } else {
    btn.classList.replace("bi-eye", "bi-eye-slash");
    btn.previousElementSibling.setAttribute("type", "password");
  }
}