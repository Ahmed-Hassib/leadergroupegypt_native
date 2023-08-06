
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
 * show_pass function
 * used to show/hide the password
 */
function show_pass(btn) {
  if (btn.classList.contains("bi-eye-slash")) {
    btn.classList.replace("bi-eye-slash", "bi-eye");
    btn.previousElementSibling.setAttribute("type", "text");
  } else {
    btn.classList.replace("bi-eye", "bi-eye-slash");
    btn.previousElementSibling.setAttribute("type", "password");
  }
}