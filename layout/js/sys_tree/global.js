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


var choosePhoto = document.getElementById("photo");
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
      } else if (localStorage['systemLang'] == 'en') {
        // add some classes
        astrisk.classList.add("astrisk-right");
      } else {
        // add some classes
        astrisk.classList.add("astrisk-left");
      }
      astrisk.textContent = "*";
      // append astrisk
      input.parentElement.appendChild(astrisk);
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
}