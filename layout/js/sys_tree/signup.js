(function () {

  // get instruction button
  let instruction_btn = document.querySelector('#instruction-btn');
  // get showing instruction check box
  let showing_instruction_checkbox = document.querySelector('#show-instructions');

  // check 'showing_instruction' variable in local storage
  if (localStorage.getItem('showing_instruction') == 'false') {
    // trigger click event on instruction button
    instruction_btn.click()
  } else {
    if (showing_instruction_checkbox != null) {
      showing_instruction_checkbox.checked = true;
    }
  }

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
  let addon_wrapping = document.querySelector("#addon-wrapping");
  // check value length
  if (value.length > 0) {
    // check if name has a white space
    if (value.match(/^[a-z]+\-*$/)) {
      // put company alias into addo wrapping
      // addon_wrapping.textContent = `@${value.trim()}`;
      // add valid class to input
      input.classList.contains("is-invalid") ? input.classList.replace("is-invalid", "is-valid") : input.classList.add("is-valid")
      // set valid attribute true
      input.dataset.valid = true;
    } else {
      // add invalid class to input
      input.classList.contains("is-valid") ? input.classList.replace("is-valid", "is-invalid") : input.classList.add("is-invalid")
      // set valid attribute false
      input.dataset.valid = false;
    }
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

