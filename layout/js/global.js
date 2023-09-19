// get main header element
var main_header_navbar = document.getElementById("website-navbar");
var cards_nums = document.querySelectorAll(".nums .num");
var inputs = document.getElementsByTagName("input");
var selects = document.getElementsByTagName("select");


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
        // add some classes
        astrisk.classList.add("astrisk-left");
      } else if (localStorage['lang'] == 'en') {
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
