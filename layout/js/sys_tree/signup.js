(function () {

  // // get instruction button
  // let instruction_btn = document.querySelector('#instruction-btn');
  // // get showing instruction check box
  // let showing_instruction_checkbox = document.querySelector('#show-instructions');

  // // check 'showing_instruction' variable in local storage
  // if (localStorage.getItem('showing_instruction') == 'false') {
  //   // trigger click event on instruction button
  //   instruction_btn.click()
  // } else {
  //   if (showing_instruction_checkbox != null) {
  //     showing_instruction_checkbox.checked = true;
  //   }
  // }

})()

function is_valid(input, type) {
  // switch ... case
  switch (type) {
    case 'company':
      check_company_name(input);
      break;

    case 'username':
      username_validation(input);
      break;

    default:
      break;
  }
}

// function to check if comapny name is exist
function check_company_name(input) {
  // get input value
  let value = input.value;

  // check value
  if (value.length > 0) {
    // get request to check if comapny name is exits
    $.get(`requests/index.php?do=check-company-name&name=${value}`, (data) => {
      // converted data
      let is_exist = $.parseJSON(data);
      // console.log(is_exist)
      // check data length
      if (is_exist == true) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        input.dataset.valid = "false";
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        input.dataset.valid = "true";
      }
    })
  } else {
    input.classList.remove('is-valid', 'is-invalid')
  }
}

function username_validation(input) {
  // get input value
  let value = input.value;
  // get addon wrapping 
  let alerts = document.querySelector("div.alert");
  // check value length
  if (value.length > 0) {
    // check if name has a white space
    // if (value.match(/^[a-z\-]+$/)) {
      // get request to check if comapny name is exits
      $.get(`requests/index.php?do=check-company-name&name=${value}`, (data) => {
        // converted data
        let is_exist = $.parseJSON(data);
        // if exist
        if (is_exist) {
          // add valid class to input
          input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
          // set valid attribute true
          input.dataset.valid = true;
          alert = create_alert('warn', 'اسم مستخدم موجود بالفعل!', 'w-100');
        } else {
          // add valid class to input
          input.classList.contains("is-invalid") ? input.classList.replace("is-invalid", "is-valid") : input.classList.add("is-valid")
          // set valid attribute true
          input.dataset.valid = true;
          alert = create_alert('success', 'اسم مستخدم صالح!', 'w-100');
        }

        if (input.parentElement.contains(alerts)) {
          alerts.remove();
        }
        
        input.parentElement.appendChild(alert)
      })
    // } else {
    //   // add invalid class to input
    //   input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
    //   // set valid attribute false
    //   input.dataset.valid = false;
    // }
  } else {
    // remove all classes
    input.classList.remove('is-valid', 'is-invalid')
  }
}

function showing_instruction(input) {
  // get input checked value
  let is_checked = input.checked;
  // store it in browser storage
  localStorage.setItem('showing_instruction', is_checked);
}

function confirm_password(confirm_pass, pass) {
  // get password value
  let pass_value = pass.value;
  // get confirmed pass value
  let confirmed_pass_value = confirm_pass.value;
  // select admin info container
  let admin_info_container = document.querySelector('#admin-info');

  // check if any alerts is added to remove it
  delete_alerts(admin_info_container);
  // get value is not empty
  if (pass_value.length > 0 && confirmed_pass_value.length > 0) {
    if (pass_value == confirmed_pass_value) {
      alert = create_alert('success', 'كلمة المرور متطابقة')
      validate_password(pass, true)
      validate_password(confirm_pass, true)
    } else {
      alert = create_alert('warn', 'كلمة المرور غير متطابقة')
      validate_password(pass, false)
      validate_password(confirm_pass, false)
    }
    // append alert
    admin_info_container.appendChild(alert)
  } else {
    validate_password(pass)
    validate_password(confirm_pass)
  }
}

function create_alert(type, message, width = 'w-50') {
  // create alert container
  let alert_container = document.createElement('div');
  // add alert classes
  alert_container.classList.add('alert', (type == 'warn' ? 'alert-warning' : 'alert-success'), width, 'mx-auto', 'my-1');
  // add alert role
  alert_container.role = 'alert';
  // create a text node
  let alert_text_node = document.createTextNode(message)
  // append text node to alert container
  alert_container.appendChild(alert_text_node);
  // create a dismiss button
  let dismiss_btn = document.createElement('button');
  // add button attribute
  dismiss_btn.type = 'button';
  dismiss_btn.classList.add('btn-close');
  dismiss_btn.dataset.bsDismiss = 'alert';
  dismiss_btn.ariaLabel = 'Close';
  dismiss_btn.style.position = 'absolute';
  dismiss_btn.style.left = '10px';
  // append dismiss button to alert container
  alert_container.appendChild(dismiss_btn);
  // return alert
  return alert_container;
}

function validate_password(input, is_valid = null) {
  if (input.value.length > 0 && is_valid != null) {
    if (is_valid) {
      input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid');
      input.dataset.valid = "true";
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid')
    input.dataset.valid = '';
  }
}

function delete_alerts(container) {
  let alerts = document.querySelectorAll('div.alert')

  if (alerts != null) {
    alerts.forEach((alert) => {
      if (container.contains(alert)) {
        alert.remove()
      }
    })
  }
}