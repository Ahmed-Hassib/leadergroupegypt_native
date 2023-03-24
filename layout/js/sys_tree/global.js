var hexChar = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F",];
var body = document.body;
var inputs = document.getElementsByTagName("input");
var selects = document.getElementsByTagName("select");
var textInputs = document.querySelectorAll("input[type=text]");
var customFormInputs = document.querySelectorAll(".custom-form input");
var showPassword = document.getElementById("show-pass");
var showPassword2 = document.getElementById("show-pass-2");
var direction = document.getElementById("direction");
var sources = document.getElementById("sources");
var altSources = document.getElementById("alternative-sources");
var pingBtn = document.getElementById("ping");
var piecesTbl = document.getElementById("piecesTbl");
var backupBtn = document.getElementById("backup");
var cardStats = document.querySelectorAll(".card-stat");
var cardLinks = document.querySelectorAll("a.stretched-link");
var client_id_search = document.querySelector("#client-id");
var client_name_search = document.querySelector("#client-name");
var client_name_result = document.getElementById("clients-names");
var choosePhoto = document.getElementById("photo");
var previewPhoto = document.getElementById("showPreviewPhoto");
var suggCompBox = document.getElementById("sugg-comp-box");
var technicalID = document.getElementById("technical-id");
var technicalIDVal = document.getElementById("technical-id-value");
var license_select = document.getElementById("license");
var license_btn = document.getElementById("renew-license-btn");
var cardsNums = document.querySelectorAll(".nums .num");
var ths = document.getElementsByTagName("th");
var previousBtn = document.getElementById('previousBtn');
var nextBtn = document.getElementById('nextBtn');
var tree = document.querySelectorAll(".tree span");
var reportSections = document.querySelectorAll(".reports .section-header");
var arrowUpBtn = document.querySelector(".arrow-up");
var delete_comb_btn = document.querySelectorAll('#delete-comb');
var confirm_delete_combination = document.querySelector("#confirm-delete-combination");
var delete_mal_btn = document.querySelectorAll('#delete-mal');
var confirm_delete_malfunction = document.querySelector("#confirm-delete-malfunction");

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

    // check if cards of nums not empty
    if (cardsNums != null) {
      cardsNums.forEach((element) => startCount(element));
    }

    // get datatables buttons
    let dataTablesBtns = document.querySelectorAll("#datatables-buttons");

    // check if not null
    if (dataTablesBtns != null) {
      dataTablesBtns.forEach(element => {
        if (localStorage['systemLang'] == 'ar') {
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


  // check if delete combination button is null 
  if (delete_comb_btn != null) {
    // loop on it
    delete_comb_btn.forEach(element => {
      element.addEventListener("click", (evt) => {
        confirm_delete_combination.setAttribute('href', `?do=deleteComb&comb_id=${element.dataset.combId}`);
      })
    });
  }

  // check if delete malfunction button is null 
  if (delete_mal_btn != null) {
    // loop on it
    delete_mal_btn.forEach(element => {
      element.addEventListener("click", (evt) => {
        confirm_delete_malfunction.setAttribute('href', `?do=deleteComb&comb_id=${element.dataset.malId}`);
      })
    });
  }

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

})();



/**
 * startCount function
 * start count from 0 to the target goal
 */
function startCount(el) {
  let goal = el.dataset.goal;
  let count = setInterval(() => {
    // check if goal not equal zero
    if (goal != 0) {
      el.textContent++;
    }
    // condition to check the stop point
    if (el.textContent == goal) {
      clearInterval(count);
    }
  }, 250 / goal);
}




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

/**
 * addAstrisk function
 * this function is used to add astrisk mark on required inputs
 */
function addAstrisk(inputs) {
  // loop on inputs
  for (const input of inputs) {
    // add astrisk on required field
    if (input.hasAttribute("required") && !input.hasAttribute("data-no-astrisk")) {
      // create span
      let astrisk = document.createElement("span");
      // add some classes
      astrisk.classList.add("text-danger", "astrisk");
      // check system language
      if (localStorage['systemLang'] == 'ar') {
        // add some classes
        astrisk.classList.add("astrisk-left");
      } else {
        // add some classes
        astrisk.classList.add("astrisk-right");
      }
      astrisk.textContent = "*";
      // append astrisk
      input.parentElement.appendChild(astrisk);
    }
  }
}



/**
 * search_name function
 * this function is used to search about the client name
 */
function search_name(evt) {
  // get name to search
  let client_name = evt.value;
  let company_id = evt.dataset.companyId;
  // check if client name box is empty or not
  if (client_name != "" && client_name.length != 0) {
    // send request
    $.get(`../requests/index.php?do=search&client-name=${client_name}&company-id=${company_id}`, (data) => {
      // convert the json data into string
      let src = $.parseJSON(data);
      // clear all previous clients names
      client_name_result.innerHTML = "";
      // check the result length
      if (src.length > 0) {
        // loop on data result to display the src
        for (let i = 0; i < src.length; i++) {
          // create a new li element
          let li = document.createElement("li");
          // add client id as an attribute
          li.setAttribute("data-id", src[i]["piece_id"]);
          // add client name as a text content
          li.textContent = src[i]["full_name"];
          // add event
          li.addEventListener("click", function (evt) {
            client_name_search.value = li.textContent;
            client_id_search.value = li.getAttribute("data-id");
            // clear all previous clients names
            client_name_result.innerHTML = "";
            // show the result
            client_name_result.style.display = "none";
          });
          // add an event when click on the one of the clients
          client_name_result.appendChild(li);
        }
      } else {
        console.log(0)
      }
    });
    // show the result
    client_name_result.style.display = "block";
  } else {
    // clear all previous clients names
    client_name_result.innerHTML = "";
    // hide the result
    client_name_result.style.display = "none";
    // clear client id
    client_id_search.value = "";
  }
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
        default_option.setAttribute('disabled', 'disabled');
        // append to select box
        select_box.appendChild(default_option);

        // check if source data has pieces or not
        if (data.length == 0) {
          console.log(fields)

          option = new Option(`${fields[0]}`, 0, true, true);
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
function getBackup(id) {
  // // get request to get backup of data
  // $.get(`../requests/index.php?do=backup&id=${id}`, (data) => {
  //     if (data == 1) {
  //         // get date and time
  //         let date = getDateNow();
  //         let time = getTimeNow();
  //         // prepare the message
  //         let message = `Backup successed on ${date} at ${time} ..`;
  //         message += "\nENG HASSIB GREATING YOU AND SAYS `HAVE A NICE DAY` ..\n";
  //         // show message
  //         alert(message);
  //     } else {
  //         console.log("cannot take a backup");
  //     }
  // });
}

/**
 * getDateNow function v1
 * This function is used to get the date for now
 */
function getDateNow(lang) {
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
 * getTimeNow function v1
 * This function is used to get the date for now
 */
function getTimeNow() {
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
 * hideList function
 */
function hideList(btn) {
  btn.nextElementSibling.classList.toggle("d-none");
  let icon = btn.children[2].children[0];
  icon.classList.contains("bi-dash-lg") ? icon.classList.replace("bi-dash-lg", "bi-plus-lg") : icon.classList.replace("bi-plus-lg", "bi-dash-lg");
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
 * 
 */
function showPreview(evt) {
  previewPhoto.innerHTML = "";
  // loop on files of the form
  for (let i = 0; i < evt.files.length; i++) {
    // uploaded type
    let type = evt.files[i]['type'].includes("video") ? "video" : "img";
    // create the image src
    var src = URL.createObjectURL(evt.files[i]);
    // create a colomn to append the image
    let col = document.createElement('div');
    col.classList.add("col-12");
    // element that will append to the preview box
    let element;
    // switch ... case ...
    switch (type) {
      case "video":
        // create video
        element = document.createElement("video");
        element.setAttribute("class", "w-100 h-100");
        element.setAttribute("autoplay", "autoplay");
        element.setAttribute("controls", "controls");
        element.setAttribute("muted", "muted");
        // element.setAttribute("loop", "loop");
        // create source tag
        videoSrc = document.createElement("source");
        videoSrc.setAttribute("src", src);
        videoSrc.setAttribute("type", `video/mp4`);
        element.appendChild(videoSrc);
        // create source tag
        videoSrc = document.createElement("source");
        videoSrc.setAttribute("src", src);
        videoSrc.setAttribute("type", `video/mov`);
        element.appendChild(videoSrc);
        // create source tag
        videoSrc = document.createElement("source");
        videoSrc.setAttribute("src", src);
        videoSrc.setAttribute("type", `video/webm`);
        element.appendChild(videoSrc);
        // append video source
        break;

      case "img":
        // create image
        element = document.createElement("img");
        element.setAttribute("src", src);
        element.setAttribute("class", "w-100 h-100");
        break;
    }
    // append image into column
    col.appendChild(element);
    // append column into the preview box
    previewPhoto.appendChild(col)
  }
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
 * showUserModal function
 */
function show_delete_user_modal(btn) {
  // check the attribute
  if (btn.hasAttribute('data-user-id')) {
    // get user id and name
    let userid = btn.getAttribute('data-user-id');
    let username = btn.getAttribute('data-username');
    // get deleteUser page url
    let url = `?do=delete-user-info&userid=${userid}`;
    // add username and url
    document.getElementById('deleted-username').textContent = username;
    document.getElementById('delete-user').setAttribute('href', url);
  }
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