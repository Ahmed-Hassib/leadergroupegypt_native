
// get mega menu button
var mega_menu_btn = document.querySelectorAll(".main-nav > li");

(function () {
  mega_menu_btn.forEach(el => {
    if (el.childElementCount > 1) {
      el.addEventListener("click", (evt) => {
        // loop on li to remove any element that have aa active class
        mega_menu_btn.forEach(el2 => {
          if (el !== el2) {
            el2.classList.remove('active')
          }
        })
        // add active class to the clicked one
        el.classList.toggle('active');
      });
    }
  })

  // show or hide delete button
  show_hide_btn();
})()


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

function show_hide_btn() {
  // get all content containers
  let content_container = document.querySelectorAll('.form-content.form-content__content');

  // check length
  if (content_container.length == 1) {
    // if length == 1 hide delete button
    let delete_btn = document.querySelector('.delete-content')

    if (delete_btn != null) delete_btn.style.display = 'none';
  } else {
    // get delete buttons
    let delete_buttons = document.querySelectorAll('.delete-content');
    // loop on delete buttons
    delete_buttons.forEach(btn => {
      // if length > 1 show delete button
      btn.style.display = 'block';
    });
  }
}


function add_new_content(id, container_id) {
  // get container that will take a clone from
  let container_content = document.querySelector(id);
  // take a clone
  let clone = container_content.cloneNode(true);
  // append clone
  document.querySelector(`#${container_id}`).appendChild(clone);
  // check cloned element
  check_clone_element(clone)
  // check content length
  show_hide_btn();
  // check if in features page
  if (location.href.includes('features')) {
    show_hide_details_btn();
  }
}

function delete_content(btn) {
  // get container
  let content_conteiner = btn.parentElement;
  // confirm delete
  if (!confirm(lang.delete_confirm)) return;
  // delete container
  content_conteiner.remove();
  // check content length
  show_hide_btn();
  // check if in features page
  if (location.href.includes('features')) {
    show_hide_details_btn();
  }
}

function check_clone_element(clone) {
  // loop on cloned content
  for (let i = 0; i < clone.children.length; i++) {
    // select current element
    const element = clone.children[i];
    // element tag name
    const el_tag_name = element.tagName.toLowerCase();
    // array of inputs
    let input_arr = ['input', 'textarea'];
    // check tag name of current element
    if (input_arr.includes(el_tag_name)) {
      element.value = '';

    } else if (el_tag_name == 'img') {
      element.src = '../../../../assets/leadergroupegypt-shadow.png';

    } else if (element.children.length > 0) {
      check_clone_element(element);
    }
  }
}

function confirm_delete(btn) {
  if (!confirm(lang.delete_confirm)) return;
  // create new link
  let new_link = `${location.origin}${location.pathname}${btn.dataset.href}`;
  // redirect page
  location.href = new_link;
}

/**
 * function to click file input to choose new image
 */
function click_input(btn) {
  // get target input
  let target_input = btn.previousElementSibling;
  // click input
  target_input.click();
}

/**
 * function to change displayed image after choose new one
 */
function change_section_img(btn) {
  // get target image
  let target_img = btn.parentElement.parentElement.nextElementSibling.children[0];
  // get image path
  let img_path = URL.createObjectURL(btn.files[0]);
  // check if target image exists
  if (target_img == null) return;
  // upload image
  target_img.setAttribute("src", img_path);
}

/**
 * function to delete image
*/
function delete_section_image(btn) {
  // get target image
  let target_img = btn.parentElement.parentElement.nextElementSibling.children[0];
  // reset image
  target_img.setAttribute("src", '../../../../data/uploads/companies-img/leadergroupegypt.jpg');
}
