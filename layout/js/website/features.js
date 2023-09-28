(function () {
  // show or hide delete button
  show_hide_details_btn();
})()


function show_hide_details_btn() {
  // get all content containers
  let content_container = document.querySelectorAll('.feature-details .feature-details__content');
  // check length
  if (content_container.length == 1) {
    // if length == 1 hide delete button
    let delete_btn = document.querySelector('.delete-details')

    if (delete_btn != null) delete_btn.style.display = 'none';
  } else {
    // get delete buttons
    let delete_buttons = document.querySelectorAll('.delete-details');
    // loop on delete buttons
    delete_buttons.forEach(btn => {
      // if length > 1 show delete button
      btn.style.display = 'block';
    });
  }
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
function change_feature_img(btn) {
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
function delete_feature_image(btn) {
  // get target image
  let target_img = btn.parentElement.parentElement.nextElementSibling.children[0];
  // reset image
  target_img.setAttribute("src", '../../../../data/uploads/companies-img/leadergroupegypt.jpg');
}

function confirm_delete_feature(btn) {
  if (!confirm(lang.delete_confirm)) return;
  // create new link
  let new_link = `${location.origin}${location.pathname}${btn.dataset.href}`;
  // redirect page
  location.href = new_link;
}



function delete_feature_detail(btn) {
  // get container
  let content_conteiner = btn.parentElement.parentElement;
  // get feature detail id
  let detail_id = btn.dataset.featureDetailId;
  // confirm delete
  if (!confirm(lang.delete_confirm)) return;
  // send a request to delete detail
  $.get(`../requests/index.php?do=delete-detail&id=${detail_id}`, (data) => {
    // check result
    if ($.parseJSON(data) == true) {
      // delete container
      content_conteiner.remove();
      // check details delete buttons
      show_hide_details_btn();
      // success message
      alert(lang.delete_feature_succ);
    } else {
      // failed message
      alert(lang.delete_feature_faild);
    }
  })
}