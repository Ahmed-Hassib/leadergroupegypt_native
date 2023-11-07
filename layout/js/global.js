// get main header element
var main_header_navbar = document.getElementById("website-navbar");
var cards_nums = document.querySelectorAll(".nums .num");
var inputs = document.getElementsByTagName("input");
var selects = document.getElementsByTagName("select");
var videos_elements = document.querySelectorAll("video");
var videos_loaders_elements = document.querySelectorAll(".video-loader-container");


(function () {
  // add an event when user scroll page
  document.onscroll = () => {
    if (main_header_navbar != null) {
      // check scroll position
      // if more than 100 make header fixed
      if (document.documentElement.scrollTop >= 50) {
        main_header_navbar.classList.add('fixed-top')
      } else {
        main_header_navbar.classList.remove('fixed-top')
      }
    }
  }

  // check if cards of nums not empty
  if (cards_nums != null) {
    cards_nums.forEach((element) => start_count(element));
  }

  // add astrisk for all required inputs
  addAstrisk(selects);
  addAstrisk(inputs);
})();

/**
 * start_count function
 * start count from 0 to the target goal
 */
function start_count(el) {
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
  }, 300 / goal);
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
      if (localStorage['lang'] == 'ar') {
        if (input.hasAttribute('dir') && input.getAttribute('dir') == 'ltr') {
          astrisk.classList.add("astrisk-right");
        } else {
          astrisk.classList.add("astrisk-left");
        }
      } else if (localStorage['lang'] == 'en') {
        if (input.hasAttribute('dir') && input.getAttribute('dir') == 'rtl') {
          astrisk.classList.add("astrisk-left");
        } else {
          astrisk.classList.add("astrisk-right");
        }
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


function confirm_password(confirm_pass, pass, container_id) {
  // get password value
  let pass_value = pass.value;
  // get confirmed pass value
  let confirmed_pass_value = confirm_pass.value;
  // select admin info container
  let info_container = document.querySelector(`#${container_id}`);

  // check if any alerts is added to remove it
  delete_alerts(info_container);
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
    info_container.appendChild(alert)
  } else {
    validate_password(pass)
    validate_password(confirm_pass)
  }
}

