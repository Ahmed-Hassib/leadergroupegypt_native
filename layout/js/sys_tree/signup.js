

function is_valid(input, type) {
  // switch ... case
  switch (type) {
    case 'username':
      check_username(input);
      break;

    case 'company':
      check_company_name(input);
      break;

    default:
      break;
  }
}

// function to check if username is exist
function check_username(input) {
  // get input value
  let value = input.value;

  // check value
  if (value.length > 0) {
    // get request to check if username is exits
    $.get(`requests/index.php?do=check-username&username=${input.value}`, (data) => {
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