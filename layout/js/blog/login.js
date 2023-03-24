$(function () {
  // get all alerts 
  var alerts = document.querySelectorAll(".alert");

  setTimeout(() => {
    alerts.forEach(alert => {
      alert.parentElement.removeChild(alert)
    });
  }, 5000);

});
// var login_form_container = document.querySelector(".blog-login-container");
// console.log(form.parentElement)
// console.log(form)

// FUNCTION TO VALIDATE LOGIN FORM
function validate_form(form) {
  // array to assign errors to it
  let err_arr = [];
  // loop on form elements
  for (let i = 0; i < form.elements.length; i++) {
    // assign element to variable
    const el = form[i];
    // check tag name
    if (el.tagName.toLowerCase() == 'input') {
      // switch case to chose the type of input
      switch (el.getAttribute('type')) {
        case 'email':
          if (el.value.length == 0) {
            err_arr.push("البريد الإلكترونى لا يمكن ان يكون فارغ");
          }else if (!validate_email(el)) {
            err_arr.push("البريد الإلكترونى غير صالح");
          }
          break;

        case 'password':
          // check if input is empty or not
          if (el.value.length == 0) {
            err_arr.push("الرقم السرى لا يمكن ان يكون فارغ");
          }

          // check if length < 8 letters
          if (el.value.length < 8) {
            err_arr.push("الرقم السرى لا يمكن ان يكون اقل من 8 احرف");
          }
          break;
      }
    }
  }

  if (err_arr.length > 0) {
    // create alerts container
    var alerts_container = document.createElement('div');
    // add a class to alerts container
    alerts_container.classList.add('alerts-container');
    // loop on errors
    err_arr.forEach(err => {
      // create an alert
      let alert = create_alert(err);
      // display error
      alerts_container.appendChild(alert);
    });
    // append alerts container to body
    document.body.appendChild(alerts_container)
    // set time out to remove it
    setTimeout(() => {
      $(alerts_container).fadeOut(500)
    }, 7000);
  }
}


// FUNCTION TO CREATE AN ALERT
function create_alert($text_alert) {
  // create an alert container
  let alert = document.createElement("div");
  // add classes to alert container
  alert.classList.add('mt-2', 'alert', 'alert-danger');
  // set attribute role=alert
  alert.setAttribute('role', 'alert');
  // add text message into the laert container
  alert.textContent = $text_alert;
  // return alert
  return alert;
}

// FUNCTION TO VALIDATE GIVEN EMAIL
function validate_email(mail) {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail.value)) {
    return true;
  }
  return false;
}
