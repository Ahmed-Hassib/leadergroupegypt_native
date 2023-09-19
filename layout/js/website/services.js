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
function change_service_img(btn) {
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
function delete_service_image(btn) {
  // get target image
  let target_img = btn.parentElement.parentElement.nextElementSibling.children[0];
  // reset image
  target_img.setAttribute("src", '../../../../data/uploads/companies-img/leadergroupegypt.jpg');
}

function confirm_delete_service(btn) {
  if (!confirm(lang.delete_confirm)) return;
  // create new link
  let new_link = `${location.origin}${location.pathname}${btn.dataset.href}`;
  // redirect page
  location.href = new_link;
}
