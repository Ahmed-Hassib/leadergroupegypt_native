

/**
 * form_validation function
 * is used to check the required fields in form
 */
function form_validation(form = null, btn = null) {
  // error array
  let errorArray = Array();

  if (form != null) {
    // get all required inputs in the form
    var inputs = document.querySelectorAll(`#${form.getAttribute('id')} input`);
    // get all required select in the form
    var selects = document.querySelectorAll(`#${form.getAttribute('id')} select`);
  } else {
    // get all required inputs in the form
    var inputs = document.querySelectorAll("input");
    // get all required select in the form
    var selects = document.querySelectorAll("select");
  }

  // loop on inputs
  inputs.forEach(input => {
    // check the required
    if (input.hasAttribute('required') && !input.hasAttribute("data-no-astrisk")) {
      // check if type of input is text
      if (input.getAttribute('type') == 'text' || input.getAttribute('type') == 'email' || input.getAttribute('type') == 'password' || input.getAttribute('type') == 'date') {
        // check if empty
        if (input.value == '' || input.dataset.valid == "false") {
          errorArray.push(input);
        } else {
          input_validation(input);
        }
      }
    }

    // if (input.getAttribute('type') == "redio") {
    //   console.log(input.checked);
    // }
  })

  // loop on selects
  selects.forEach(select => {
    // check the required
    if (select.hasAttribute('required') && !select.hasAttribute("data-no-astrisk")) {
      // check if user not select anything
      if (select.selectedIndex == 0 || select.dataset.valid == "false") {
        errorArray.push(select);
      } else {
        input_validation(select);
      }
    }
  })

  // check array of the error
  if (errorArray.length > 0) {
    // loop on inputs to validate it
    errorArray.forEach(el => {
      input_validation(el);
    })

    form.dataset.valid = false
    // scroll on the top of the page
    document.body.scrollTo(0, 0);
  } else {
    form.dataset.valid = true
    // no error => check if the form is null
    // if not null submit it
    if (btn != null && form != null && form.dataset.valid == "true") {
      form.submit();
    }
  }
}


/**
 * input_validation function
 * is used to check the specific required input in form
 */
function input_validation(input) {
  // if input is empty
  if (input.value.length == 0 || input.selectedIndex == 0) {
    // check if have an valid class
    input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
    input.dataset.valid = "false";
  } else {
    input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid');
    input.dataset.valid = "true";
  } 
}



/**
 * fullname_validation function
 * used for full name validation  
 */
function fullname_validation(input, id = null) {
  // get input value
  let value = input.value;

  // check vallue
  if (value.length > 0) {
    // type of message
    let is_valid = false;
    // check id is set
    if (id != null) {
      url_content = `../requests/index.php?do=check-piece-fullname&full_name=${value}&id=${id}`;
    } else {
      url_content = `../requests/index.php?do=check-piece-fullname&full_name=${value}`;
    }
    // get request to check if full name is exist or not
    $.get(url_content, (res) => {
      // convert result
      let result = $.parseJSON(res);
      // is_exist variable
      let is_exist = result[0];
      // counter variable
      let counter = result[1];
      // check if exist
      if (is_exist == true && counter > 0) {
        // add invalid class to input
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
        // set boolean variable false
        input.dataset.valid = "false";
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        // set boolean variable true
        input.dataset.valid = "true";
      }
    });
  } else {
    input.classList.remove('is-valid', 'is-invalid');
  }
}

/**
 * ip_validation function
 * used for full name validation  
 */
function ip_validation(input, id = null) {
  // get input value
  let value = input.value;

  // check vallue
  if (value.length > 0) {
    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(value)) {
      // type of message
      let is_valid = false;
      // check id is set
      if (id != null) {
        url_content = `../requests/index.php?do=check-piece-ip&ip=${value}&id=${id}`;
      } else {
        url_content = `../requests/index.php?do=check-piece-ip&ip=${value}`;
      }

      if (value != '0.0.0.0') {
        // get request to check if full name is exist or not
        $.get(url_content, (res) => {
          // converted data
          let result = $.parseJSON(res);
          // is_exist
          let is_exist = result[0];
          // counter
          let counter = result[1];
          // check if exist
          if (is_exist == true && counter > 0) {
            // add invalid class to input
            input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
            input.dataset.valid = "false";
            // set boolean variable false
            is_valid = false;
          } else {
            input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
            input.dataset.valid = "true";
            // set boolean variable true
            is_valid = true;
          }
        });
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        input.dataset.valid = "true";
      }
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid');
  }
}

/**
 * mac_validation function
 * used for full name validation  
 */
function mac_validation(input, id = null) {
  // get input value
  let value = input.value;

  if (value.length > 0) {
    if (/^[0-9a-f]{1,2}([.:-])[0-9a-f]{1,2}(?:\1[0-9a-f]{1,2}){4}$/i.test(value)) {
      // check vallue
      // type of message
      let is_valid = false;
      // check id is set
      if (id != null) {
        url_content = `../requests/index.php?do=check-piece-macadd&mac_add=${value}&id=${id}`;
      } else {
        url_content = `../requests/index.php?do=check-piece-macadd&mac_add=${value}`;
      }
      // get request to check if full name is exist or not
      $.get(url_content, (res) => {
        // converted data
        let result = $.parseJSON(res);
        // is_exist
        let is_exist = result[0];
        // counter
        let counter = result[1];
        // check if exist
        if (is_exist == true && counter > 0) {
          // add invalid class to input
          input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
          input.dataset.valid = "false";
          // set boolean variable false
          is_valid = false;
        } else {
          input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
          input.dataset.valid = "true";
          // set boolean variable true
          is_valid = true;
        }
      });
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid');
  }
}

function double_input_validation(input) {
  // get input value
  let value = input.value;

  // check value length
  if (value.length > 0) {
    // check value
    if (/^\d{0,4}(\.\d{0,2}){0,1}$/.test(value)) {
      input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
      input.dataset.valid = "true";
    } else {
      input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid')
      input.dataset.valid = "false";
    }
  } else {
    input.classList.remove('is-valid', 'is-invalid');
  }
}


// function to check if username is exist
function check_username(input) {
  // get input value
  let value = input.value;

  // check value
  if (value.length > 0) {
    // get request to check if username is exits
    $.get(`../requests/index.php?do=check-username&username=${input.value}`, (res) => {
      // converted res
      let result = $.parseJSON(res);
      // is_exist
      let is_exist = result[0];
      // counter
      let counter = result[1];
      // check data length
      if (is_exist == true && counter > 0) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        input.dataset.valid = "false";
        input.form.dataset.valid = "false";
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        input.dataset.valid = "true";
        input.form.dataset.valid = "true";
      }
    })
  } else {
    input.classList.remove('is-valid', 'is-invalid')
  }
}

function direction_validation(input) {
  // get input value
  let value = input.value;
  // get direction id 
  let id = input.dataset.id;

  // check value
  if (value.length > 0) {
    // check id is set
    if (id != null) {
      url_content = `../requests/index.php?do=check-direction&direction-name=${value}&id=${id}`;
    } else {
      url_content = `../requests/index.php?do=check-direction&direction-name=${value}`;
    }
    // get request to check if direction is exits
    $.get(url_content, (res) => {
      // converted res
      let result = $.parseJSON(res);
      // is_exist
      let is_exist = result[0];
      // counter
      let counter = result[1];
      // console.log(is_exist)
      // check data length
      if (is_exist == true && counter > 0) {
        input.classList.contains('is-valid') ? input.classList.replace('is-valid', 'is-invalid') : input.classList.add('is-invalid');
        input.dataset.valid = "false";
        input.form.dataset.valid = "false";
      } else {
        input.classList.contains('is-invalid') ? input.classList.replace('is-invalid', 'is-valid') : input.classList.add('is-valid')
        input.dataset.valid = "true";
        input.form.dataset.valid = "true";
      }
    })
  } else {
    input.classList.remove('is-valid', 'is-invalid')
  }
}