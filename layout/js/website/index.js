
// get mega menu button
var mega_menu_btn = document.querySelectorAll(".main-nav > li");

(function () {
    mega_menu_btn.forEach(el => {
        if (el.childElementCount > 1) {
            el.addEventListener("click", (evt) => {
                // loop on li to remove any element that have aa active class
                mega_menu_btn.forEach(el2 => {
                    if (el !== el2) {
                        el2.classList.remove('active')
                    }
                })
                // add active class to the clicked one
                el.classList.toggle('active');
            });
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