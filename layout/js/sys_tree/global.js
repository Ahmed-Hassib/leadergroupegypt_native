var inputs = document.getElementsByTagName("input");
var selects = document.getElementsByTagName("select");
var textInputs = document.querySelectorAll("input[type=text]");
var customFormInputs = document.querySelectorAll(".custom-form input");
var showPassword = document.getElementById("show-pass");
var showPassword2 = document.getElementById("show-pass-2");
var direction = document.getElementById("direction");
var sources = document.getElementById("sources");
var altSources = document.getElementById("alternative-sources");
var cardStats = document.querySelectorAll(".card-stat");
var cardLinks = document.querySelectorAll("a.stretched-link");

var choosePhoto = document.getElementById("photo");
var suggCompBox = document.getElementById("sugg-comp-box");
var technicalID = document.getElementById("technical-id");
var technicalIDVal = document.getElementById("technical-id-value");
var license_select = document.getElementById("license");
var license_btn = document.getElementById("renew-license-btn");
var ths = document.getElementsByTagName("th");
var previousBtn = document.getElementById('previousBtn');
var nextBtn = document.getElementById('nextBtn');
var tree = document.querySelectorAll(".tree span");
var reportSections = document.querySelectorAll(".reports .section-header");
var arrowUpBtn = document.querySelector(".arrow-up");

// self invoke function .
(function () {

  // window on load
  window.onload = function () {
    if (technicalIDVal != null) {
      technicalIDVal.value = technicalID.value;

      technicalID.addEventListener("change", (evt) => {
        evt.preventDefault();
        technicalIDVal.value = technicalID.value;
      });
    }

    // get datatables buttons
    let dataTablesBtns = document.querySelectorAll("#datatables-buttons");

    // check if not null
    if (dataTablesBtns != null) {
      dataTablesBtns.forEach(element => {
        if (localStorage['lang'] == 'ar') {
          element.style.direction = 'ltr';
        }
      });
      // get datatables buttons
      const btns = document.querySelectorAll('.dt-buttons button');

      // loop on it
      for (let i = 0; i < btns.length; i++) {
        // current element
        const btn = btns[i];
        // check current element tag name 
        if (btn.tagName.toLowerCase() == 'button') {
          // remove btn-secondary class
          btn.classList.replace('btn-secondary', 'btn-outline-primary')
          btn.classList.add('fs-12', 'py-1')
        } else {
          // get current child
          const el = btn.children[0];
          // remove btn-secondary class
          el.classList.replace('btn-secondary', 'btn-outline-primary')
          el.classList.add('fs-12', 'py-1')
        }
      }
    }
  };


  if (reportSections.length > 0) {
    reportSections.forEach(el => {
      el.addEventListener("click", (evt) => {
        evt.preventDefault();
        // check icon
        let icon = el.children[2].children[0];
        if (icon.classList.contains("bi-dash")) {
          icon.classList.replace("bi-dash", "bi-plus")
        } else {
          icon.classList.replace("bi-plus", "bi-dash")
        }
        el.nextElementSibling.classList.toggle("d-none")
      })
    });
  }

  // add astrisk
  addAstrisk(selects);
  addAstrisk(inputs);


  /**
 * hide placeholder from inputs when focus
 * show placeholder when blur
 */
  if (inputs != null) {
    // when focus or blur on input form
    for (const input of inputs) {
      // when focus on input delete placeholder
      input.addEventListener("focus", function (event) {
        input.setAttribute("data-text", input.getAttribute("placeholder"));
        input.setAttribute("placeholder", "");
      });

      // when blur on input delete placeholder
      input.addEventListener("blur", function (event) {
        input.setAttribute("placeholder", input.getAttribute("data-text"));
        input.setAttribute("data-text", "");
      });
    }
  }


  // get all ips
  let ips_elements = document.querySelectorAll(".pcs-ip");
  let online = 0;
  let offline = 0;

  if (ips_elements.length > 0) {
    // loop on ips
    ips_elements.forEach(ip_element => {
      let ip = ip_element.dataset.pcsIp;
      let device_status = ip_element.previousElementSibling;
      let preloader_status = device_status != null ? device_status.previousElementSibling : null;
      if (ip != '0.0.0.0' && preloader_status != null) {
        // check ip connection
        check_ip_connection(ip, preloader_status, device_status)
        setInterval(() => {
          check_ip_connection(ip, preloader_status, device_status)
        }, 600000);
      }
    })
  }
})();

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

function check_ip_connection(ip, preloader_status, device_status) {

  $.get(`../requests/index.php?do=ping&ip=${ip}&c=1`, (data) => {
    // convert result
    let ping_res = $.parseJSON(data);

    // hide preloader
    preloader_status.remove();
    // check device status
    if (ping_res.status == 'success' && ping_res.data.length > 7) {
      device_status.classList.add('badge', 'bg-success', 'd-inline-block', 'p-1');
      device_status.title = "online"
    } else if (ping_res.status == 'success' && ping_res.data.length <= 7) {
      device_status.classList.add('badge', 'bg-danger', 'd-inline-block', 'p-1');
      device_status.title = "offline";
    } else {
      device_status.classList.add('badge', 'bg-danger', 'd-inline-block', 'p-1');
      device_status.title = "offline";
    }
  });
}

function get_sources(dir_select, company_id, location, box) {
  // get direction id
  let dir_id = dir_select.value;
  // get direction name
  let dir_name = dir_select.options[dir_select.selectedIndex].textContent;
  // json file name
  let json_file_name = "";
  // get all pieces data ..
  $.get(`../requests/index.php?do=get-source&dir-id=${dir_id}&company=${company_id}`, (data) => {
    // console.log(data);
    // assign json file name to the variable
    json_file_name = $.parseJSON(data);

    // get data from json file
    $.ajax({
      url: `${location}/${json_file_name}`,
      dataType: 'json',
      cache: false,
      success: function (data, status) {
        for (let i = 0; i < box.length; i++) {
          put_data_into_select(data, status, box[i], 'source', dir_name.trim());
        }
      },
      error: function (xhr, textStatus, err) {
        // for error message
      }
    })
  });
}

function put_data_into_select(data, status, box, type, ...fields) {
  // check the status
  if (status === "success") {
    var select_box = document.getElementById(box);
    // remove all sources children
    select_box.innerHTML = "";

    switch (type) {
      case 'source':
        // check the select box
        if (box == 'sources') {
          default_text = `اختر المصدر`;
        } else {
          default_text = `اختر المصدر البديل`;
        }
        default_option = new Option(default_text, 'default', true, true);
        // default_option.setAttribute('disabled', 'disabled');
        // append to select box
        select_box.appendChild(default_option);
        // check if source data has pieces or not
        if (data.length == 0) {
          option = new Option(`${fields[0]}`, 0, false, false);
          select_box.appendChild(option);
        } else {
          // loop on data result to display the data
          for (let i = 0; i < data.length; i++) {
            option = new Option(`${data[i]["ip"]} - ${data[i]["full_name"]}`, data[i]["id"], false, false);
            select_box.appendChild(option);
          }
        }
        break;

      case 'model':
        select_box.innerHTML = '';
        default_option = new Option('اختر موديل الجهاز', 'default', true, true);
        default_option.setAttribute('disabled', 'disabled');
        // append to select box
        select_box.appendChild(default_option);

        // check if source data has pieces or not
        if (data.length > 0) {
          // loop on data result to display the data
          for (let i = 0; i < data.length; i++) {
            option = new Option(`${data[i]["model_name"]}`, data[i]["model_id"], false, false);
            select_box.appendChild(option);
          }
        }
        break;

      default:
        break;
    }
  }
}

/**
 *
 */
function ping(ip, ping_counter = null) {
  $.get(`../requests/index.php?do=ping&ip=${ip}&c=${ping_counter}`, (data) => {
    // convert result
    let ping_res = $.parseJSON(data);
    // final result
    let final_result = '';
    // display result of ping
    if (ping_res.status == 'success' && ping_res.data.length > 7) {
      final_result = `IP ADDRESS: ${ping_res.data[2].split('=')[2]}<br>`;
      final_result += `ttl: ${ping_res.data[4].split('=')[2]}<br>`;
      final_result += `time: ${ping_res.data[5].split('=')[2]}<br>`;
      final_result += `number of sent messages: ${ping_res.data[6].split('=')[2]}, number of received messages: ${ping_res.data[7].split('=')[2]}<br>`;
      final_result += `packet loss: ${ping_res.data[8].split('=')[2]}<br>`;
      final_result += `min rtt: ${ping_res.data[9].split('=')[2]}, avg rtt: ${ping_res.data[10].split('=')[2]}, avg rtt: ${ping_res.data[11].split('=')[2]}<br>`;
      final_result += `<hr>Request created at: ${ping_res.created_at}<br>`;
    } else if (ping_res.status == 'success' && ping_res.data.length <= 7) {
      final_result = `Status: ${ping_res.data[2].split('=')[2]}<br>`;
      final_result += `number of sent messages: ${ping_res.data[3].split('=')[2]}, number of received messages: ${ping_res.data[4].split('=')[2]}<br>`;
      final_result += `packet loss: ${ping_res.data[5].split('=')[2]}<br>`;
      final_result += `<hr>Request created at: ${ping_res.created_at}<br>`;
    } else {
      final_result = "<span class='text-danger'>Request Error...<span><br>";
    }
    // display result
    document.querySelector(".modal-body .ping-preloader").classList.add('d-none');

    // hide preloader
    document.querySelector('#ping-status').innerHTML = final_result;
  })
}

function reset_modal() {
  document.querySelector(".ping-preloader").classList.remove('d-none');
  document.querySelector('#ping-status').textContent = '';
}

/**
 * get_date_now function v1
 * This function is used to get the date for now
 */
function get_date_now(lang) {
  // dayes array in arabic
  const days_ar = ["الاحد", "الاثنين", "الثلاثاء", "لالربعاء", "الخميس", "الجمعة", "السبت"];
  // dayes array in english
  const days_en = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  // months array in arabic
  const months_ar = ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "اغسطس", "سبتمبر", "اكتوبر", "نوفمبر", "ديسمبر"];
  // months array in english
  const months_en = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  // date object to get full date and time details
  let dateObj = new Date();
  // check language
  if (lang == "ar") {
    date = `${days_ar[dateObj.getDay()]}, ${months_ar[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;
  } else {
    date = `${days_en[dateObj.getDay()]}, ${months_en[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;
  }
  // return the date
  return date;
}


/**
 * get_time_now function v1
 * This function is used to get the date for now
 */
function get_time_now() {
  // date object to get full date and time details
  let dateObj = new Date();
  // prepare the time
  let time = "";
  // check the time mode
  if (dateObj.getHours() < 12) {
    time = `${dateObj.getHours()}:${dateObj.getMinutes()} Am`;
  } else {
    time = `${dateObj.getHours() - 12}:${dateObj.getMinutes()} pm`;
  }
  // return the date
  return time;
}



/**
 * getUserPermission function
 */
function getUserPermission(selected) {
  // get selected option value
  let selValue = selected.value;
  // get parent
  let sibling = selected.previousElementSibling;
  // change sibling value
  sibling.value = selValue;
}



/**
 * show avatar
 */
function showSuggCompDetails(id) {
  // display the details box
  suggCompBox.style.display = "block";
  // get request to get backup of data
  $.get(`../requests/index.php?do=getSuggComp&id=${id}`, (data) => {
    let suggComp = $.parseJSON(data);
    document.getElementById("sugg-comp-id").value = suggComp['id'];
    if (suggComp['type'] == 0) {
      document.getElementById("suggDetails").setAttribute("checked", "checked");
    } else {
      document.getElementById("compDetails").setAttribute("checked", "checked");
    }
  });
}


/**
 * select_all_checkboxes function
 */
function select_all_checkboxes(btn) {
  // get all inputs in the form
  let inputs = document.querySelectorAll('input[type=checkbox]');
  // check if input button is checked or not
  if (btn.checked) {
    for (let i = 1; i < inputs.length; i++) {
      inputs[i].checked = true;
    }
  } else {
    for (let i = 1; i < inputs.length; i++) {
      inputs[i].checked = false;
    }
  }
}


/**
 * submit form of the button
 * 
 */
function submitForm(btn) {
  let myForm = btn.form;
  myForm.submit();
}

function upload_image(btn) {
  // soldier image element
  let emp_img_element = btn.parentElement.previousElementSibling;
  // get image path
  let imgPath = URL.createObjectURL(btn.files[0]);
  // upload image
  emp_img_element.setAttribute("src", imgPath);

  emp_img_element.addEventListener("click", (evt) => {
    emp_img_element.classList.add('full-screen');
  })
}


/**
 * arabic_to_english_nums function
 * used to convert arabic numbers into english
 */
function arabic_to_english_nums(input) {
  // arabic digits
  let ar_digits = {
    '٠': 0,
    '١': 1,
    '٢': 2,
    '٣': 3,
    '٤': 4,
    '٥': 5,
    '٦': 6,
    '٧': 7,
    '٨': 8,
    '٩': 9,
  };
  // english charachters
  let en_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

  // '٧٧٥٤٢'
  // get value of the input 
  // then convert it into string 
  // then split it into an array to loop on it
  let input_digits = input.value.toString().split("");
  // final result variable
  let res = '';
  // loop on array of input`s value
  for (let i = 0; i < input_digits.length; i++) {
    // check if ar_digit has value of input_digits[i]
    if (ar_digits.hasOwnProperty(input_digits[i])) {
      // if exist replace it with its value
      res += ar_digits[input_digits[i]];
    } else {
      // if not exist keep it
      res += input_digits[i];
    }
  }
  // loop on array of input`s value
  for (let i = 0; i < input_digits.length; i++) {
    // check if result contains any characters
    if (en_chars.indexOf(input_digits[i]) >= 0) {
      // if contains replace it with empty space
      res = res.replace(input_digits[i], "");
    }
  }

  // remove any spaces in result
  res = res.replace(/\s+/g, '');
  res = res.replace(/[^\w]/g, '');
  // replace input`s value within the new value
  input.value = res;

  console.log(res)
}


/**
 * show_display_side_btns function
 * used to show or hide fixed side buttons
 */
function show_display_side_btns(clicked_btn) {
  // get side buttons
  let side_btn = document.querySelector('.fixed-scroll-btn');
  // get icon child
  let icon = clicked_btn.querySelector('i.bi');
  // toggle status
  side_btn.classList.toggle('d-none')
  // toggle icon
  icon.classList.toggle('bi-eye')
  icon.classList.toggle('bi-eye-slash')
}


// function to get latitude and langitude
function getLatLong(coordinateString) {
  // Split the string by comma to separate latitude and longitude
  const coordinates = coordinateString.split(',');

  // check coordinates
  if (coordinates.length == 2) {
    // Assuming the first value is latitude and second is longitude
    const lat = parseFloat(coordinates[0]);
    const lng = parseFloat(coordinates[1]);
    // Return an object containing latitude and longitude
    return { lat, lng };
  }

  // return null if not valid coordinates
  return null;
}
