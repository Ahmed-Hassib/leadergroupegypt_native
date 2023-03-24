// get main header element
var main_header_navbar = document.getElementById("header");

$(function () {
  // add an event when user scroll page
  document.onscroll = () => {
    if (main_header_navbar != null ) {

      // check scroll position
      // if more than 100 make header fixed
      if (document.documentElement.scrollTop >= 50) {
        main_header_navbar.style.position = 'fixed';
      } else {
        main_header_navbar.style.position = 'relative';
      }
    }
  }
})